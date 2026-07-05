<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Complète le schéma de l'équipe avec les colonnes nécessaires
 * à l'admin et aux filtres du front. Chaque ajout est protégé :
 * si la colonne existe déjà, elle n'est pas recréée.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            if (! Schema::hasColumn('produits', 'nom')) {
                $table->string('nom')->after('id');          // absent du schéma initial : indispensable
            }
            if (! Schema::hasColumn('produits', 'slug')) {
                $table->string('slug')->unique()->after('nom'); // URLs propres pour le SEO
            }
            if (! Schema::hasColumn('produits', 'occasion')) {
                $table->string('occasion')->nullable()->after('matiere'); // filtre : cadeau, bureau...
            }
            if (! Schema::hasColumn('produits', 'histoire')) {
                $table->text('histoire')->nullable()->after('description'); // storytelling (brief)
            }
            if (! Schema::hasColumn('produits', 'actif')) {
                $table->boolean('actif')->default(true);
            }
            if (! Schema::hasColumn('produits', 'mis_en_avant')) {
                $table->boolean('mis_en_avant')->default(false);
            }
            if (! Schema::hasColumn('produits', 'created_at')) {
                $table->timestamps();
            }
        });

        Schema::table('produit_images', function (Blueprint $table) {
            if (! Schema::hasColumn('produit_images', 'principale')) {
                $table->boolean('principale')->default(false)->after('url');
            }
            if (! Schema::hasColumn('produit_images', 'created_at')) {
                $table->timestamps();
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (! Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->nullable()->after('nom');
            }
            if (! Schema::hasColumn('categories', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn(['nom', 'slug', 'occasion', 'histoire', 'actif', 'mis_en_avant']);
        });
        Schema::table('produit_images', function (Blueprint $table) {
            $table->dropColumn('principale');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
