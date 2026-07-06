<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            if (! Schema::hasColumn('produits', 'modele_id')) {
                // Identifiant du modèle commun à tous les coloris.
                // Nullable : un sac sans variante n'a pas besoin d'être relié.
                $table->unsignedBigInteger('modele_id')->nullable()->after('id');
                $table->index('modele_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropIndex(['modele_id']);
            $table->dropColumn('modele_id');
        });
    }
};
