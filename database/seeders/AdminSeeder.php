<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Couleur;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Compte administrateur (à personnaliser puis changer le mot de passe !)
        User::updateOrCreate(
            ['email' => 'admin@blacjoyaux.com'],
            [
                'name' => 'Manuela Kouadio',
                'password' => Hash::make('BlacJoyaux2026!'),
                'is_admin' => true,
            ]
        );

        // Collections issues du brief
        $collections = [
            'Joyau de Bla' => 'Collection phare inspirée de la poupée de fécondité ashanti.',
            'Collection DO' => 'Deuxième collection prioritaire de la maison.',
            'Sac de bureau' => 'Le modèle attendu de la capsule : élégance au travail.',
            'Capsule' => 'Les nouveaux modèles imaginés pour la collection capsule.',
        ];

        foreach ($collections as $nom => $description) {
            Categorie::firstOrCreate(
                ['nom' => $nom],
                ['slug' => Str::slug($nom), 'description' => $description]
            );
        }

        // Couleurs de départ
        $couleurs = [
            ['nom' => 'Noir', 'code_hex' => '#141110'],
            ['nom' => 'Camel', 'code_hex' => '#B0713A'],
            ['nom' => 'Crème', 'code_hex' => '#F2E9DA'],
            ['nom' => 'Doré', 'code_hex' => '#B98A2F'],
            ['nom' => 'Rouge', 'code_hex' => '#8E2323'],
            ['nom' => 'Vert forêt', 'code_hex' => '#25402C'],
        ];

        foreach ($couleurs as $c) {
            Couleur::firstOrCreate(['nom' => $c['nom']], $c);
        }
    }
}
