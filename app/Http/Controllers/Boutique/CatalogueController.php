<?php

namespace App\Http\Controllers\Boutique;

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
            ->take(4)->get();

        // Si rien n'est mis en avant, on montre les derniers sacs
        if ($misEnAvant->isEmpty()) {
            $misEnAvant = Produit::where('actif', true)
                ->with(['imagePrincipale', 'categorie'])
                ->latest('id')->take(4)->get();
        }

        return view('boutique.accueil', [
            'misEnAvant' => $misEnAvant,
            'categories' => Categorie::withCount('produits')->orderBy('nom')->get(),
        ]);
    }

    public function index(Request $request)
    {
        $produits = Produit::where('actif', true)
            ->with(['imagePrincipale', 'categorie', 'couleurs'])
            ->filtre($request->all())
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('boutique.catalogue', [
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
            ->with(['images', 'couleurs', 'categorie'])
            ->firstOrFail();

        $variantes = $produit->variantes();

        $similaires = Produit::where('actif', true)
            ->where('categorie_id', $produit->categorie_id)
            ->where('id', '!=', $produit->id)
            ->with('imagePrincipale')
            ->take(3)->get();

        // Lien WhatsApp pré-rempli : la cliente arrive avec sa question déjà écrite
        $messageWhatsapp = rawurlencode(
            "Bonjour Blac Joyaux ! Je suis intéressée par le sac « {$produit->nom} » à {$produit->prixFormate()}. Est-il disponible ?"
        );
        $lienWhatsapp = 'https://wa.me/' . config('boutique.whatsapp') . '?text=' . $messageWhatsapp;

        return view('boutique.produit', compact('produit', 'variantes', 'similaires', 'lienWhatsapp'));
    }
}
