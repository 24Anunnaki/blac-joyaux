<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Reproduit le schéma conçu par l'équipe (MySQL Workbench).
 * Chaque création est protégée par hasTable : si la table existe
 * déjà dans votre base MySQL, elle n'est pas touchée.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('nom');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('produits')) {
            Schema::create('produits', function (Blueprint $table) {
                $table->id();
                $table->foreignId('categorie_id')->constrained('categories')->cascadeOnDelete();
                $table->text('description')->nullable();
                $table->unsignedInteger('prix');
                $table->string('matiere')->nullable();
                $table->string('dimensions')->nullable();
                $table->unsignedInteger('stock')->default(0);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('produit_images')) {
            Schema::create('produit_images', function (Blueprint $table) {
                $table->id();
                $table->string('url');
                $table->unsignedInteger('ordre')->default(0);
                $table->foreignId('product_id')->constrained('produits')->cascadeOnDelete();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('clients')) {
            Schema::create('clients', function (Blueprint $table) {
                $table->id();
                $table->string('nom');
                $table->string('prenom');
                $table->string('email')->unique();
                $table->string('telephone');
                $table->string('adresse')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('commandes')) {
            Schema::create('commandes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
                $table->string('statut')->default('en_attente');
                $table->unsignedInteger('total');
                $table->string('mode_paiement')->nullable();   // orange_money, mtn, wave, especes
                $table->string('mode_livraison')->nullable();
                $table->string('delai')->nullable();           // ex : 1 à 3 jours
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('lignes_commandes')) {
            Schema::create('lignes_commandes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('commande_id')->constrained('commandes')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('produits')->cascadeOnDelete();
                $table->unsignedInteger('quantite')->default(1);
                $table->unsignedInteger('prix_unitaire');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('lignes_commandes');
        Schema::dropIfExists('commandes');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('produit_images');
        Schema::dropIfExists('produits');
        Schema::dropIfExists('categories');
    }
};
