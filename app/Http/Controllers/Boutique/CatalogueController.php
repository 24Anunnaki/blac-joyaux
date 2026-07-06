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


    /**
     * Vitrine de la collection capsule, branchée sur la base :
     * les sacs affichés sont de vrais produits (achetables, filtrables).
     */
    public function capsule()
    {
        $produitsCapsule = Produit::where('actif', true)
            ->whereHas('categorie', fn ($q) => $q->where('slug', 'capsule'))
            ->with(['imagePrincipale', 'images', 'couleurs'])
            ->orderBy('prix', 'desc')
            ->get();

        return view('boutique.capsule', compact('produitsCapsule'));
    }

    /**
     * Pages storytelling individuelles de la capsule (design du front).
     * Chacune reçoit son vrai produit pour lier vers la fiche achetable.
     */
    public function capsuleSaphirNoir()
    {
        return $this->pageCapsule('saphir-noir', 'boutique.capsule-saphir-noir');
    }

    public function capsuleIndigo()
    {
        return $this->pageCapsule('indigo-de-bla', 'boutique.capsule-indigo-bla');
    }

    public function capsuleKente()
    {
        return $this->pageCapsule('kente', 'boutique.capsule-kente');
    }

    private function pageCapsule(string $slug, string $vue)
    {
        // Le produit réel correspondant (créé par CapsuleSeeder).
        // Nullable : la page reste consultable même si le seeder n'a pas tourné,
        // mais la vue doit tester @if($produit) avant d'afficher prix / bouton panier.
        $produit = Produit::where('slug', $slug)
            ->where('actif', true)
            ->with(['imagePrincipale', 'images', 'couleurs'])
            ->first();

        return view($vue, compact('produit'));
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
