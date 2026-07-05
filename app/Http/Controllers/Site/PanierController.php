<?php

namespace App\Http\Controllers\Site;

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
        return view('site.panier', [
            'lignes' => $this->panier->lignes(),
            'total' => $this->panier->total(),
        ]);
    }

    public function ajouter(Request $request, Produit $produit)
    {
        abort_unless($produit->actif, 404);

        $quantite = max(1, (int) $request->input('quantite', 1));

        if ($produit->stock < $quantite) {
            return back()->withErrors(['stock' => 'Stock insuffisant pour ce modèle.']);
        }

        $this->panier->ajouter($produit->id, $quantite);

        return redirect()->route('panier')
            ->with('succes', "« {$produit->nom} » a été ajouté à votre panier.");
    }

    public function modifier(Request $request, Produit $produit)
    {
        $this->panier->modifier($produit->id, (int) $request->input('quantite', 1));

        return redirect()->route('panier');
    }

    public function retirer(Produit $produit)
    {
        $this->panier->retirer($produit->id);

        return redirect()->route('panier');
    }
}
