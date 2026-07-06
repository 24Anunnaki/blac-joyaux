<?php

/*
|--------------------------------------------------------------------------
| Routes de la boutique publique Blac Joyaux
|--------------------------------------------------------------------------
| Tunnel du brief : Découverte → Site → WhatsApp → Achat rassuré
*/

use App\Http\Controllers\Boutique\CatalogueController;
use App\Http\Controllers\Boutique\CommandeController;
use App\Http\Controllers\Boutique\PaiementController;
use App\Http\Controllers\Boutique\PanierController;
use Illuminate\Support\Facades\Route;

Route::name('boutique.')->group(function () {

    Route::get('/', [CatalogueController::class, 'accueil'])->name('accueil');
    Route::get('/capsule', [CatalogueController::class, 'capsule'])->name('capsule');
    Route::get('/capsule/saphir-noir', [CatalogueController::class, 'capsuleSaphirNoir'])->name('capsule.saphir');
    Route::get('/capsule/indigo-de-bla', [CatalogueController::class, 'capsuleIndigo'])->name('capsule.indigo');
    Route::get('/capsule/kente', [CatalogueController::class, 'capsuleKente'])->name('capsule.kente');
    Route::get('/sacs', [CatalogueController::class, 'index'])->name('catalogue');
    Route::get('/sacs/{slug}', [CatalogueController::class, 'show'])->name('produit');

    // Panier (session, sans compte)
    Route::get('/panier', [PanierController::class, 'index'])->name('panier');
    Route::post('/panier/{produit}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
    Route::patch('/panier/{cle}', [PanierController::class, 'modifier'])->name('panier.modifier');
    Route::delete('/panier/{cle}', [PanierController::class, 'retirer'])->name('panier.retirer');

    // Commande invitée
    Route::get('/commande', [CommandeController::class, 'create'])->name('commande');
    Route::post('/commande', [CommandeController::class, 'store'])->name('commande.store');

    // Paiement simulé + confirmation
    Route::get('/paiement/{commande}', [PaiementController::class, 'show'])->name('paiement');
    Route::post('/paiement/{commande}', [PaiementController::class, 'simuler'])->name('paiement.simuler');
    Route::get('/confirmation/{commande}', [PaiementController::class, 'confirmation'])->name('confirmation');

    // Capsules
    Route::get('/capsule/saphir-noir', [CatalogueController::class, 'capsuleSaphirNoir'])->name('capsule.saphir');
    Route::get('/capsule/indigo-de-bla', [CatalogueController::class, 'capsuleIndigo'])->name('capsule.indigo');
    Route::get('/capsule/kente', [CatalogueController::class, 'capsuleKente'])->name('capsule.kente');


});
