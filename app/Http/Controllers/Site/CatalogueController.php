<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Couleur;
use App\Models\Produit;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function accueil()
    {
        $misEnAvant = Produit::where('actif', true)
            ->where('mis_en_avant', true)
            ->with(['imagePrincipale', 'categorie'])
            ->latest('id')
            ->take(6)
            ->get();

        // Si rien n'est mis en avant, on montre les derniers sacs
        if ($misEnAvant->isEmpty()) {
            $misEnAvant = Produit::where('actif', true)
                ->with(['imagePrincipale', 'categorie'])
                ->latest('id')
                ->take(6)
                ->get();
        }

        return view('site.accueil', compact('misEnAvant'));
    }

    public function index(Request $request)
    {
        $produits = Produit::where('actif', true)
            ->with(['imagePrincipale', 'categorie', 'couleurs'])
            ->filtre($request->all())
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('site.catalogue', [
            'produits' => $produits,
            'categories' => Categorie::orderBy('nom')->get(),
            'couleurs' => Couleur::orderBy('nom')->get(),
            'matieres' => Produit::matieres(),
            'occasions' => Produit::occasions(),
        ]);
    }

    public function show(string $slug)
    {
        $produit = Produit::where('slug', $slug)
            ->where('actif', true)
            ->with(['images', 'categorie', 'couleurs'])
            ->firstOrFail();

        $similaires = Produit::where('actif', true)
            ->where('categorie_id', $produit->categorie_id)
            ->where('id', '!=', $produit->id)
            ->with('imagePrincipale')
            ->take(3)
            ->get();

        // Données structurées Product (SEO / AI-First : livrable du brief)
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $produit->nom,
            'description' => $produit->description ?: "Sac {$produit->nom} — maroquinerie ivoirienne Blac Joyaux.",
            'image' => $produit->images->map(fn ($i) => $i->lien())->values(),
            'brand' => ['@type' => 'Brand', 'name' => 'Blac Joyaux'],
            'material' => $produit->matiere,
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => 'XOF',
                'price' => $produit->prix,
                'availability' => $produit->stock > 0
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'itemCondition' => 'https://schema.org/NewCondition',
            ],
        ];

        // FAQ produit (répond aux freins du brief : confiance + manque d'information)
        $faq = [
            [
                'q' => 'Quels sont les délais de livraison ?',
                'r' => 'Livraison à Abidjan et en Côte d\'Ivoire sous 1 à 3 jours ouvrés après confirmation de la commande.',
            ],
            [
                'q' => 'Quels moyens de paiement acceptez-vous ?',
                'r' => 'Orange Money, MTN MoMo, Wave, ou espèces à la livraison.',
            ],
            [
                'q' => 'Puis-je l\'offrir en cadeau ?',
                'r' => 'Oui ! Choisissez l\'option emballage cadeau lors de la commande et ajoutez votre message personnalisé.',
            ],
            [
                'q' => 'Où est fabriqué ce sac ?',
                'r' => 'Chaque sac Blac Joyaux est fabriqué à la main à Abidjan par notre artisan partenaire — authentique made in Côte d\'Ivoire.',
            ],
        ];

        $faqJsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($item) => [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['r']],
            ], $faq),
        ];

        return view('site.produit', compact('produit', 'similaires', 'jsonLd', 'faq', 'faqJsonLd'));
    }
}
