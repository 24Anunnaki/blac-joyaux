<?php

namespace Database\Seeders;

use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Couleur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeder de test AUTO-NETTOYANT pour les VARIANTES DE COULEUR (Option A).
 *
 * Cree 2 modeles, chacun decline en 3 coloris (6 produits relies par modele_id).
 *
 * IMPORTANT : au debut, il SUPPRIME d'abord ses propres produits de test
 * (reperes par leur slug), donc tu peux le relancer autant de fois que tu
 * veux sans creer de doublons.
 *
 * Lancer   :  php artisan db:seed --class=VariantesTestSeeder
 * Nettoyer :  decommente la ligne indiquee dans run() puis relance.
 */
class VariantesTestSeeder extends Seeder
{
    /**
     * Les slugs crees par ce seeder. Sert a retrouver et supprimer SES produits.
     */
    private array $slugsDeTest = [
        'le-joyau-noir', 'le-joyau-bordeaux', 'le-joyau-camel',
        'le-sac-bureau-bleu-roi', 'le-sac-bureau-rose-vif', 'le-sac-bureau-vert',
    ];

    public function run(): void
    {
        // 0. NETTOYAGE : on supprime d'abord les anciens produits de test
        $this->nettoyer();

        // Pour SEULEMENT nettoyer (tout enlever sans recreer),
        // decommente la ligne suivante puis relance le seeder :
        // return $this->command->info('Produits de test supprimes. Rien recree.');

        // 1. Categories
        $catJoyau = Categorie::firstOrCreate(
            ['nom' => 'Joyau de Bla'],
            ['slug' => 'joyau-de-bla', 'description' => 'Collection phare.']
        );

        $catBureau = Categorie::firstOrCreate(
            ['nom' => 'Collection DO'],
            ['slug' => 'collection-do', 'description' => 'Deuxieme collection.']
        );

        // 2. Couleurs (avec code hex pour les pastilles)
        $couleurs = [
            'Noir'      => '#1A1A1A',
            'Bordeaux'  => '#6B0F2A',
            'Camel'     => '#C8783C',
            'Bleu roi'  => '#1A3FA0',
            'Rose vif'  => '#E0407A',
            'Vert'      => '#1E8A4C',
        ];

        $couleurModels = [];
        foreach ($couleurs as $nom => $hex) {
            $couleurModels[$nom] = Couleur::firstOrCreate(
                ['nom' => $nom],
                ['code_hex' => $hex]
            );
        }

        // 3. MODELE 1 - "Le Joyau" en 3 coloris
        $this->creerModele(
            $catJoyau, 'Le Joyau', 65000, 'Cuir', 'Quotidien',
            "Notre piece iconique, ornee de la poupee doree de fecondite ashanti.",
            [
                ['suffixe' => 'Noir',     'couleur' => $couleurModels['Noir']],
                ['suffixe' => 'Bordeaux', 'couleur' => $couleurModels['Bordeaux']],
                ['suffixe' => 'Camel',    'couleur' => $couleurModels['Camel']],
            ]
        );

        // 4. MODELE 2 - "Le Sac Bureau" en 3 coloris
        $this->creerModele(
            $catBureau, 'Le Sac Bureau', 85000, 'Cuir', 'Bureau',
            "Structure et elegant, pense pour la jeune cadre. Spacieux et raffine.",
            [
                ['suffixe' => 'Bleu roi',  'couleur' => $couleurModels['Bleu roi']],
                ['suffixe' => 'Rose vif',  'couleur' => $couleurModels['Rose vif']],
                ['suffixe' => 'Vert',      'couleur' => $couleurModels['Vert']],
            ]
        );

        $this->command->info('OK : 2 modeles crees, 3 coloris chacun (6 produits relies).');
    }

    /**
     * Supprime les produits de test precedemment crees par ce seeder.
     */
    private function nettoyer(): void
    {
        $anciens = Produit::whereIn('slug', $this->slugsDeTest)->get();

        foreach ($anciens as $produit) {
            $produit->couleurs()->detach();
            $produit->delete();
        }

        if ($anciens->count() > 0) {
            $this->command->info($anciens->count() . ' ancien(s) produit(s) de test supprime(s).');
        }
    }

    /**
     * Cree un modele decline en plusieurs coloris, relies par modele_id.
     */
    private function creerModele(
        Categorie $categorie,
        string $nomBase,
        int $prix,
        string $matiere,
        string $occasion,
        string $description,
        array $coloris
    ): void {
        $modeleId = null;

        foreach ($coloris as $index => $c) {
            $nomComplet = "{$nomBase} {$c['suffixe']}";

            $produit = Produit::create([
                'nom'          => $nomComplet,
                'slug'         => Str::slug($nomComplet),
                'categorie_id' => $categorie->id,
                'description'  => $description,
                'histoire'     => "Faconne a la main dans un atelier d'Adjame.",
                'prix'         => $prix,
                'stock'        => 10,
                'matiere'      => $matiere,
                'occasion'     => $occasion,
                'dimensions'   => '30 x 22 x 12 cm',
                'actif'        => true,
                'mis_en_avant' => $index === 0,
            ]);

            if ($modeleId === null) {
                $modeleId = $produit->id;
            }
            $produit->modele_id = $modeleId;
            $produit->save();

            $produit->couleurs()->attach($c['couleur']->id);
        }
    }
}
