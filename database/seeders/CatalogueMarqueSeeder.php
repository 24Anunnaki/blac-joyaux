<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Couleur;
use App\Models\Produit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Catalogue des produits réels de la marque (source : blacjoyaux.com/boutique).
 *
 * Prérequis : placer les photos dans public/images/marque/ avec les noms
 * listés ci-dessous (elles voyagent alors par Git, comme celles de la capsule).
 *
 * Relançable sans doublon (firstOrCreate partout) :
 *   php artisan db:seed --class=CatalogueMarqueSeeder
 */
class CatalogueMarqueSeeder extends Seeder
{
    public function run(): void
    {
        /* ----- Collections ----- */
        $collectionDo = Categorie::firstOrCreate(
            ['nom' => 'Collection DO'],
            ['slug' => 'collection-do', 'description' => 'La collection Dominique Ouattara : cuirs patinés et textures précieuses.']
        );
        $joyauDeBla = Categorie::firstOrCreate(
            ['nom' => 'Joyau de Bla'],
            ['slug' => 'joyau-de-bla', 'description' => 'La collection phare, ornée de la poupée de fécondité ashanti.']
        );

        /* ----- Couleurs ----- */
        $couleurs = [
            'Marron' => '#8B5A2B',
            'Bleu ciel' => '#A8C4D4',
            'Serpent' => '#B8AFA0',
            'Noir' => '#141110',
            'Doré' => '#B98A2F',
        ];
        $couleurIds = [];
        foreach ($couleurs as $nom => $hex) {
            $couleurIds[$nom] = Couleur::firstOrCreate(['nom' => $nom], ['code_hex' => $hex])->id;
        }

        /* ----- Produits ----- */
        // 'chef' => null : modèle indépendant ; sinon slug du chef de file (déclaré avant lui)
        $produits = [
            [
                'nom' => 'Sac DO — Cuir Marron',
                'categorie' => $collectionDo,
                'prix' => 50000,
                'stock' => 5,
                'matiere' => 'Cuir',
                'occasion' => 'Bureau',
                'couleur' => 'Marron',
                'chef' => null,
                'description' => "Sac à main structuré en cuir marron aux reflets patinés, poignée courte et fermoir doré signé. Format compact qui accompagne aussi bien la journée de travail que le déjeuner en ville.",
                'histoire' => null,
                'images' => 'do-cuir-marron',
                'dimensions' => '25 × 15 × 8 cm',
            ],
            [
                'nom' => 'Sac DO — Cuir Marron à boucle',
                'categorie' => $collectionDo,
                'prix' => 50000,
                'stock' => 5,
                'matiere' => 'Cuir',
                'occasion' => 'Bureau',
                'couleur' => 'Marron',
                'chef' => 'sac-do-cuir-marron',
                'description' => "La version à boucle du sac DO : même cuir marron patiné, rehaussé d'un fermoir à boucle qui affirme le caractère. Poignée courte, intérieur doublé.",
                'histoire' => null,
                'images' => 'do-cuir-marron-boucle',
                'dimensions' => '25 × 15 × 8 cm',
            ],
            [
                'nom' => 'Sac DO — Croco Lézard',
                'categorie' => $collectionDo,
                'prix' => 70000,
                'stock' => 3,
                'matiere' => 'Cuir',
                'occasion' => 'Soirée',
                'couleur' => 'Noir',
                'chef' => null,
                'description' => "Pièce de caractère en cuir noir texturé façon croco-lézard, fermoir doré gravé Blac Joyaux. Le relief de la matière accroche la lumière — un sac qui se remarque sans élever la voix.",
                'histoire' => null,
                'images' => 'do-croco-lezard',
                'dimensions' => '25 × 15 × 8 cm',
            ],
            [
                'nom' => 'Joyau de Bla — Doré',
                'categorie' => $joyauDeBla,
                'prix' => 50000,
                'stock' => 6,
                'matiere' => 'Cuir vegan',
                'occasion' => 'Cadeau',
                'couleur' => 'Doré',
                'chef' => null,
                'description' => "Le Joyau de Bla nouvelle version en cuir vegan doré, frappé de la poupée ashanti. Poignée courte, format trapèze, doublure soignée — la pièce lumière de la collection.",
                'histoire' => "L'or de la fête, la poupée de l'héritage : ce Joyau doré est celui qu'on offre pour marquer un moment. Il dit « tu comptes », sans un mot. L'avenir en main.",
                'images' => 'joyau-dore',
                'dimensions' => '24 × 16 × 7 cm',
            ],
            [
                'nom' => 'Joyau de Bla — Croco Bleu Ciel (petit format)',
                'categorie' => $joyauDeBla,
                'prix' => 70000,
                'stock' => 4,
                'matiere' => 'Cuir vegan',
                'occasion' => 'Cadeau',
                'couleur' => 'Bleu ciel',
                'chef' => 'joyau-de-bla-dore',
                'description' => "Petit format en texture croco bleu ciel, poupée dorée en signature. Une teinte rare en maroquinerie locale, fraîche et lumineuse, portée main ou en appoint.",
                'histoire' => null,
                'images' => 'joyau-croco-bleu-ciel',
                'dimensions' => '20 × 13 × 6 cm',
            ],
            [
                'nom' => 'Joyau de Bla — Peau de Serpent (petit format)',
                'categorie' => $joyauDeBla,
                'prix' => 50000,
                'stock' => 4,
                'matiere' => 'Cuir vegan',
                'occasion' => 'Soirée',
                'couleur' => 'Serpent',
                'chef' => 'joyau-de-bla-dore',
                'description' => "Version texture serpent aux nuances naturelles, poupée dorée, petit format à poignée courte. Le motif organique en fait une pièce unique à chaque exemplaire.",
                'histoire' => null,
                'images' => 'joyau-peau-serpent',
                'dimensions' => '20 × 13 × 6 cm',
            ],
        ];

        $sourceImages = public_path('images/marque');
        $destination = storage_path('app/public/produits');
        File::ensureDirectoryExists($destination);

        foreach ($produits as $donnees) {
            $slug = Str::slug($donnees['nom']);
            $produit = Produit::firstOrCreate(
                ['slug' => $slug],
                [
                    'nom' => $donnees['nom'],
                    'categorie_id' => $donnees['categorie']->id,
                    'prix' => $donnees['prix'],
                    'stock' => $donnees['stock'],
                    'matiere' => $donnees['matiere'],
                    'occasion' => $donnees['occasion'],
                    'dimensions' => $donnees['dimensions'],   // ← AJOUTE CETTE LIGNE ICI
                    'description' => $donnees['description'],
                    'histoire' => $donnees['histoire'],
                    'actif' => true,
                    'mis_en_avant' => false,
                ]
            );

            // Couleur du coloris (utilisée par le filtre et la pastille de variante)
            $produit->couleurs()->syncWithoutDetaching([$couleurIds[$donnees['couleur']]]);

            // Variantes Option A : rattachement au chef de file ou chef de sa propre lignée
            if ($donnees['chef']) {
                $chef = Produit::where('slug', $donnees['chef'])->first();
                $produit->modele_id = $chef?->modele_id ?? $chef?->id ?? $produit->id;
            } elseif (! $produit->modele_id) {
                $produit->modele_id = $produit->id;
            }
            $produit->save();

            // Photos : copiées depuis public/images/marque (versionné Git) vers le stockage produits
            if ($produit->images()->count() === 0) {
                // Prend toutes les vues numérotées : prefixe-1.jpg, prefixe-2.jpg, ...
                $fichiers = File::glob($sourceImages . '/' . $donnees['images'] . '-[0-9]*.jpg');
                sort($fichiers);
                $ordre = 0;
                foreach ($fichiers as $source) {
                    $nom = basename($source);
                    File::copy($source, $destination . '/' . $nom);
                    $produit->images()->create([
                        'url' => 'produits/' . $nom,
                        'principale' => $ordre === 0,
                        'ordre' => ++$ordre,
                    ]);
                }
                if ($ordre === 0) {
                    $this->command?->warn("Aucune photo trouvée pour {$donnees['images']}-*.jpg");
                }
            }

            $this->command?->info("Marque : « {$produit->nom} » prêt ({$produit->images()->count()} photo(s)).");
        }
    }
}
