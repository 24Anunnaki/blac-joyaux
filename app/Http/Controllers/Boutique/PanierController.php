<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Services\Panier;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function __construct(private Panier $panier)
    {
    }

    public function index()
    {
        return view('boutique.panier', [
            'lignes' => $this->panier->contenu(),
            'total' => $this->panier->total(),
        ]);
    }

    public function ajouter(Request $request, Produit $produit)
    {
        $donnees = $request->validate([
            'couleur' => ['nullable', 'string', 'max:50'],
            'quantite' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        if ($produit->stock < 1) {
            return back()->withErrors(['stock' => 'Ce modèle est momentanément épuisé. Contactez-nous sur WhatsApp pour être prévenue de son retour.']);
        }

        $this->panier->ajouter($produit->id, $donnees['couleur'] ?? null, $donnees['quantite'] ?? 1);

        return redirect()->route('boutique.panier')
            ->with('succes', "« {$produit->nom} » a été ajouté à votre panier.");
    }

    public function modifier(Request $request, string $cle)
    {
        $donnees = $request->validate(['quantite' => ['required', 'integer', 'min:0', 'max:10']]);

        $this->panier->modifierQuantite($cle, $donnees['quantite']);

        return redirect()->route('boutique.panier');
    }

    public function retirer(string $cle)
    {
        $this->panier->retirer($cle);

        return redirect()->route('boutique.panier')->with('succes', 'Article retiré du panier.');
    }
}
