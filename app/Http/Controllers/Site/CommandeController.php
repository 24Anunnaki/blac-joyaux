<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Produit;
use App\Services\Panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommandeController extends Controller
{
    public function __construct(private Panier $panier)
    {
    }

    public function create()
    {
        if (empty($this->panier->lignes())) {
            return redirect()->route('catalogue');
        }

        return view('site.commande', [
            'lignes' => $this->panier->lignes(),
            'total' => $this->panier->total(),
        ]);
    }

    public function store(Request $request)
    {
        $lignes = $this->panier->lignes();

        if (empty($lignes)) {
            return redirect()->route('catalogue');
        }

        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'telephone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'adresse_livraison' => ['required', 'string', 'max:255'],
            'mode_livraison' => ['required', 'in:domicile,showroom'],
            'emballage_cadeau' => ['nullable', 'boolean'],
            'message_cadeau' => ['nullable', 'string', 'max:500'],
        ], [
            'nom.required' => 'Votre nom est nécessaire pour la livraison.',
            'telephone.required' => 'Votre numéro nous permet de confirmer la commande.',
            'adresse_livraison.required' => 'Indiquez votre quartier ou adresse de livraison.',
        ]);

        // Vérification du stock avant de créer la commande
        foreach ($lignes as $ligne) {
            if ($ligne['produit']->stock < $ligne['quantite']) {
                return back()->withErrors([
                    'stock' => "Le sac « {$ligne['produit']->nom} » n'est plus disponible en quantité suffisante.",
                ]);
            }
        }

        $commande = DB::transaction(function () use ($donnees, $lignes) {

            // Cliente identifiée par son téléphone (pas de compte requis)
            $client = Client::updateOrCreate(
                ['telephone' => $donnees['telephone']],
                [
                    'nom' => $donnees['nom'],
                    'prenom' => $donnees['prenom'],
                    'email' => $donnees['email'] ?? $donnees['telephone'].'@commande.blacjoyaux.local',
                    'adresse' => $donnees['adresse_livraison'],
                ]
            );

            $commande = Commande::create([
                'client_id' => $client->id,
                'reference' => 'BJ-'.strtoupper(Str::random(6)),
                'statut' => 'en_attente',
                'total' => array_sum(array_column($lignes, 'sous_total')),
                'mode_livraison' => $donnees['mode_livraison'],
                'adresse_livraison' => $donnees['adresse_livraison'],
                'delai' => '1 à 3 jours',
                'emballage_cadeau' => (bool) ($donnees['emballage_cadeau'] ?? false),
                'message_cadeau' => $donnees['message_cadeau'] ?? null,
            ]);

            foreach ($lignes as $ligne) {
                $commande->lignes()->create([
                    'product_id' => $ligne['produit']->id,
                    'quantite' => $ligne['quantite'],
                    'prix_unitaire' => $ligne['produit']->prix,
                ]);

                Produit::where('id', $ligne['produit']->id)
                    ->decrement('stock', $ligne['quantite']);
            }

            return $commande;
        });

        $this->panier->vider();

        return redirect()->route('paiement', $commande);
    }
}
