<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Transforme les 3 modèles de la collection capsule en VRAIS produits :
 * en base, achetables, filtrables, gérables dans l'admin.
 *
 * Les photos ajoutées par le front dans public/images/capsule/ sont copiées
 * vers le stockage produits (storage/app/public/produits) pour que la fiche
 * produit les serve normalement via ProduitImage->lien().
 *
 * Relançable sans risque : firstOrCreate partout (aucun doublon).
 *
 *   php artisan db:seed --class=CapsuleSeeder
 */
class CapsuleSeeder extends Seeder
{
    public function run(): void
    {
        $capsule = Categorie::firstOrCreate(
            ['nom' => 'Capsule'],
            ['slug' => 'capsule', 'description' => 'La collection capsule : 2 à 3 modèles imaginés pour la marque.']
        );

        $modeles = [
            [
                'nom' => 'Saphir Noir',
                'prix' => 95000,
                'stock' => 3,
                'matiere' => 'Cuir',
                'occasion' => 'Bureau',
                'dimensions' => '38 × 28 × 12 cm',
                'description' => "Le sac de bureau de la capsule : cuir noir profond, poupée Joyaux de Bla frappée d'or, compartiment matelassé pour ordinateur 14\", poches organisées et fermeture sécurisée. Pensé pour la jeune cadre qui veut allier élégance et efficacité.",
                'histoire' => "Saphir Noir comble le manque identifié de la collection : le sac qui accompagne les journées de travail. Le noir de la maison, la rigueur d'un format bureau, l'éclat discret de la poupée ashanti — l'avenir en main, du premier rendez-vous au dernier e-mail.",
                'images' => ['saphir_noir1.jpeg', 'saphir_noir2.jpeg', 'saphir_noir3.jpeg', 'saphir_noir4.jpeg'],
                'mis_en_avant' => true,
            ],
            [
                'nom' => 'Indigo de Bla',
                'prix' => 75000,
                'stock' => 4,
                'matiere' => 'Cuir',
                'occasion' => 'Cadeau',
                'dimensions' => '26 × 19 × 10 cm',
                'description' => "Sac porté épaule en cuir teinté indigo, rehaussé de la poupée dorée et de finitions main. La teinte bleu nuit, rare en maroquinerie locale, en fait une pièce à offrir — livrée dans son emballage cadeau.",
                'histoire' => "L'indigo, couleur des étoffes précieuses d'Afrique de l'Ouest, rencontre la poupée de fécondité ashanti. Indigo de Bla est né pour être offert : un joyau de nuit qui se transmet, comme on transmet une histoire.",
                'images' => ['indigo_bla1.jpeg', 'indigo_bla2.jpeg', 'indigo_bla3.jpeg'],
                'mis_en_avant' => false,
            ],
            [
                'nom' => 'Kente',
                'prix' => 85000,
                'stock' => 4,
                'matiere' => 'Tissu wax',
                'occasion' => 'Cérémonie',
                'dimensions' => '30 × 22 × 11 cm',
                'description' => "Pièce signature de la capsule : cuir et tissu tissé aux motifs kente, anses renforcées, intérieur doublé. Chaque exemplaire est unique, les motifs variant selon la coupe du tissu.",
                'histoire' => "Le kente, tissé royal du monde akan, raconte le prestige et la fête. Marié au cuir de la maison, il devient un sac de cérémonie qui porte l'héritage en pleine lumière — authentique made in CI, jusque dans la trame.",
                'images' => ['kente1.jpeg', 'kente2.jpeg', 'kente3.jpeg', 'kente4.jpeg', 'kente5.jpeg'],
                'mis_en_avant' => false,
            ],
        ];

        // Dossier de destination des photos produits
        $destination = storage_path('app/public/produits');
        File::ensureDirectoryExists($destination);

        foreach ($modeles as $donnees) {
            $slug = Str::slug($donnees['nom']);

            $produit = Produit::firstOrCreate(
                ['slug' => $slug],
                [
                    'nom' => $donnees['nom'],
                    'categorie_id' => $capsule->id,
                    'prix' => $donnees['prix'],
                    'stock' => $donnees['stock'],
                    'matiere' => $donnees['matiere'],
                    'occasion' => $donnees['occasion'],
                    'dimensions' => $donnees['dimensions'],
                    'description' => $donnees['description'],
                    'histoire' => $donnees['histoire'],
                    'actif' => true,
                    'mis_en_avant' => $donnees['mis_en_avant'],
                ]
            );

            // Chef de file de son propre modèle (système de variantes Option A)
            if (! $produit->modele_id) {
                $produit->modele_id = $produit->id;
                $produit->save();
            }

            // Copier les photos du front (public/images/capsule) vers le stockage produits
            if ($produit->images()->count() === 0) {
                $ordre = 0;
                foreach ($donnees['images'] as $fichier) {
                    $source = public_path('images/capsule/' . $fichier);
                    if (! File::exists($source)) {
                        $this->command?->warn("Image introuvable, ignorée : {$fichier}");
                        continue;
                    }

                    File::copy($source, $destination . '/' . $fichier);

                    $produit->images()->create([
                        'url' => 'produits/' . $fichier,
                        'principale' => $ordre === 0,
                        'ordre' => ++$ordre,
                    ]);
                }
            }

            $this->command?->info("Capsule : « {$produit->nom} » prêt ({$produit->images()->count()} photos).");
        }
    }
}
