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
                $table->string('reference')->nullable()->unique()->after('id'); // ex: BJ-8F3K2A
            }
            if (! Schema::hasColumn('commandes', 'adresse_livraison')) {
                $table->string('adresse_livraison')->nullable()->after('mode_livraison');
            }
            if (! Schema::hasColumn('commandes', 'emballage_cadeau')) {
                $table->boolean('emballage_cadeau')->default(false); // usage dominant du brief
            }
            if (! Schema::hasColumn('commandes', 'message_cadeau')) {
                $table->text('message_cadeau')->nullable();
            }
            if (! Schema::hasColumn('commandes', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn(['reference', 'adresse_livraison', 'emballage_cadeau', 'message_cadeau']);
        });
    }
};
