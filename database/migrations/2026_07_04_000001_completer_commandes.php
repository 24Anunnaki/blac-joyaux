<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            if (! Schema::hasColumn('commandes', 'reference')) {
                $table->string('reference')->nullable()->unique();       // réf. de paiement simulé
            }
            if (! Schema::hasColumn('commandes', 'adresse_livraison')) {
                $table->string('adresse_livraison')->nullable();         // quartier + précisions
            }
            if (! Schema::hasColumn('commandes', 'emballage_cadeau')) {
                $table->boolean('emballage_cadeau')->default(false);     // usage dominant du brief
            }
            if (! Schema::hasColumn('commandes', 'message_cadeau')) {
                $table->string('message_cadeau', 300)->nullable();
            }
            if (! Schema::hasColumn('commandes', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });

        Schema::table('lignes_commandes', function (Blueprint $table) {
            if (! Schema::hasColumn('lignes_commandes', 'couleur')) {
                $table->string('couleur')->nullable();                   // couleur choisie
            }
            if (! Schema::hasColumn('lignes_commandes', 'created_at')) {
                $table->timestamps();
            }
        });

        Schema::table('clients', function (Blueprint $table) {
            if (! Schema::hasColumn('clients', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn(['reference', 'adresse_livraison', 'emballage_cadeau', 'message_cadeau']);
        });
        Schema::table('lignes_commandes', function (Blueprint $table) {
            $table->dropColumn('couleur');
        });
    }
};
