<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('couleurs')) {
            Schema::create('couleurs', function (Blueprint $table) {
                $table->id();
                $table->string('nom');
                $table->string('code_hex', 7)->default('#000000');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('couleur_produit')) {
            // On lit le type EXACT des colonnes id existantes (int, bigint...)
            $typeProduit = $this->typeColonne('produits', 'id');
            $typeCouleur = $this->typeColonne('couleurs', 'id');

            DB::statement("
                CREATE TABLE couleur_produit (
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    produit_id {$typeProduit} NOT NULL,
                    couleur_id {$typeCouleur} NOT NULL,
                    UNIQUE KEY couleur_produit_unique (produit_id, couleur_id),
                    CONSTRAINT fk_cp_produit FOREIGN KEY (produit_id)
                        REFERENCES produits (id) ON DELETE CASCADE,
                    CONSTRAINT fk_cp_couleur FOREIGN KEY (couleur_id)
                        REFERENCES couleurs (id) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('couleur_produit');
        Schema::dropIfExists('couleurs');
    }

    private function typeColonne(string $table, string $colonne): string
    {
        $info = DB::selectOne("
            SELECT COLUMN_TYPE AS type
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND COLUMN_NAME = ?
        ", [$table, $colonne]);

        return strtoupper($info->type);
    }
};
