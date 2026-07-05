<?php

namespace App\Services;

use App\Models\Produit;
use Illuminate\Support\Facades\Session;

/**
 * Panier stocké en session : pas de compte obligatoire (achat invité).
 * Structure : [ "produitId-couleur" => ['produit_id', 'couleur', 'quantite'] ]
 */
class Panier
{
    private const CLE = 'panier';

    public function contenu(): array
    {
        $lignes = Session::get(self::CLE, []);
        if (empty($lignes)) {
            return [];
        }

        $produits = Produit::with('imagePrincipale')
            ->whereIn('id', array_column($lignes, 'produit_id'))
            ->get()
            ->keyBy('id');

        $resultat = [];
        foreach ($lignes as $cle => $ligne) {
            $produit = $produits->get($ligne['produit_id']);
            if (! $produit) {
                continue; // produit supprimé entre-temps
            }
            $resultat[$cle] = [
                'produit' => $produit,
                'couleur' => $ligne['couleur'],
                'quantite' => $ligne['quantite'],
                'sous_total' => $produit->prix * $ligne['quantite'],
            ];
        }

        return $resultat;
    }

    public function ajouter(int $produitId, ?string $couleur, int $quantite = 1): void
    {
        $lignes = Session::get(self::CLE, []);
        $cle = $produitId . '-' . ($couleur ?: 'defaut');

        $lignes[$cle] = [
            'produit_id' => $produitId,
            'couleur' => $couleur,
            'quantite' => ($lignes[$cle]['quantite'] ?? 0) + $quantite,
        ];

        Session::put(self::CLE, $lignes);
    }

    public function modifierQuantite(string $cle, int $quantite): void
    {
        $lignes = Session::get(self::CLE, []);
        if (! isset($lignes[$cle])) {
            return;
        }
        if ($quantite <= 0) {
            unset($lignes[$cle]);
        } else {
            $lignes[$cle]['quantite'] = $quantite;
        }
        Session::put(self::CLE, $lignes);
    }

    public function retirer(string $cle): void
    {
        $lignes = Session::get(self::CLE, []);
        unset($lignes[$cle]);
        Session::put(self::CLE, $lignes);
    }

    public function total(): int
    {
        return array_sum(array_column($this->contenu(), 'sous_total'));
    }

    public function nombreArticles(): int
    {
        return array_sum(array_column(Session::get(self::CLE, []), 'quantite'));
    }

    public function vider(): void
    {
        Session::forget(self::CLE);
    }
}
