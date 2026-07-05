<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index(Request $request)
    {
        $commandes = Commande::with('client')
            ->withCount('lignes')
            ->when($request->input('statut'), fn ($q, $statut) => $q->where('statut', $statut))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.commandes.index', [
            'commandes' => $commandes,
            'statuts' => Commande::STATUTS,
            'enAttente' => Commande::where('statut', 'en_attente')->count(),
        ]);
    }

    public function show(Commande $commande)
    {
        $commande->load(['client', 'lignes.produit.imagePrincipale']);

        return view('admin.commandes.show', [
            'commande' => $commande,
            'statuts' => Commande::STATUTS,
        ]);
    }

    public function updateStatut(Request $request, Commande $commande)
    {
        $donnees = $request->validate([
            'statut' => ['required', 'in:' . implode(',', array_keys(Commande::STATUTS))],
        ]);

        $commande->update(['statut' => $donnees['statut']]);

        return back()->with('succes', 'Statut mis à jour : ' . $commande->statutLisible() . '.');
    }
}
