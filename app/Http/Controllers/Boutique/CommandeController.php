<?php

namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Commande;
use App\Services\Panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function __construct(private Panier $panier)
    {
    }

    public function create()
    {
        if (empty($this->panier->contenu())) {
            return redirect()->route('boutique.catalogue');
        }

        return view('boutique.commande', [
            'lignes' => $this->panier->contenu(),
            'total' => $this->panier->total(),
            'quartiers' => config('boutique.quartiers'),
        ]);
    }

    public function store(Request $request)
    {
        $lignes = $this->panier->contenu();
        if (empty($lignes)) {
            return redirect()->route('boutique.catalogue');
        }

        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'telephone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'quartier' => ['required', 'string', 'max:100'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'emballage_cadeau' => ['nullable', 'boolean'],
            'message_cadeau' => ['nullable', 'string', 'max:300'],
        ], [
            'nom.required' => 'Votre nom est nécessaire pour la livraison.',
            'prenom.required' => 'Votre prénom est nécessaire pour la livraison.',
            'telephone.required' => 'Le livreur vous contactera sur ce numéro.',
            'quartier.required' => 'Indiquez votre quartier de livraison.',
        ]);

        $commande = DB::transaction(function () use ($donnees, $request, $lignes) {
            // Achat invité : le client est identifié par son téléphone, pas de compte à créer
            $client = Client::updateOrCreate(
                ['telephone' => $donnees['telephone']],
                [
                    'nom' => $donnees['nom'],
                    'prenom' => $donnees['prenom'],
                    'email' => $donnees['email'] ?? ($donnees['telephone'] . '@client.blacjoyaux.local'),
                    'adresse' => trim(($donnees['quartier'] ?? '') . ' — ' . ($donnees['adresse'] ?? ''), ' —'),
                ]
            );

            $commande = Commande::create([
                'client_id' => $client->id,
                'statut' => 'en_attente',
                'total' => $this->panier->total(),
                'mode_livraison' => 'Livraison à domicile',
                'adresse_livraison' => trim($donnees['quartier'] . ' — ' . ($donnees['adresse'] ?? ''), ' —'),
                'delai' => '1 à 3 jours',
                'emballage_cadeau' => $request->boolean('emballage_cadeau'),
                'message_cadeau' => $donnees['message_cadeau'] ?? null,
            ]);

            foreach ($lignes as $ligne) {
                $commande->lignes()->create([
                    'product_id' => $ligne['produit']->id,
                    'quantite' => $ligne['quantite'],
                    'prix_unitaire' => $ligne['produit']->prix,
                    'couleur' => $ligne['couleur'],
                ]);

                // Décrément du stock (sans passer en négatif)
                $ligne['produit']->decrement('stock', min($ligne['quantite'], $ligne['produit']->stock));
            }

            return $commande;
        });

        $this->panier->vider();
        session(['derniere_commande' => $commande->id]);

        return redirect()->route('boutique.paiement', $commande);
    }
}
