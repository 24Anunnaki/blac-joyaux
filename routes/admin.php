<?php

/*
|--------------------------------------------------------------------------
| Routes de l'administration Blac Joyaux
|--------------------------------------------------------------------------
| À inclure dans routes/web.php avec :
|     require __DIR__.'/admin.php';
*/

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\CommandeController;
use App\Http\Controllers\Admin\CouleurController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    // Connexion
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Espace protégé
    Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {

        Route::redirect('/', '/admin/sacs');

        // Sacs
        Route::resource('sacs', ProduitController::class)
            ->parameters(['sacs' => 'produit'])
            ->names('produits')
            ->except(['show']);

        Route::delete('sacs/{produit}/images/{image}', [ProduitController::class, 'destroyImage'])
            ->name('produits.images.destroy');
        Route::patch('sacs/{produit}/images/{image}/couverture', [ProduitController::class, 'setCover'])
            ->name('produits.images.cover');

        // Collections (catégories)
        Route::get('collections', [CategorieController::class, 'index'])->name('categories.index');
        Route::post('collections', [CategorieController::class, 'store'])->name('categories.store');
        Route::delete('collections/{categorie}', [CategorieController::class, 'destroy'])->name('categories.destroy');

        // Commandes
        Route::get('commandes', [CommandeController::class, 'index'])->name('commandes.index');
        Route::get('commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
        Route::patch('commandes/{commande}/statut', [CommandeController::class, 'updateStatut'])->name('commandes.statut');

        // Couleurs
        Route::get('couleurs', [CouleurController::class, 'index'])->name('couleurs.index');
        Route::post('couleurs', [CouleurController::class, 'store'])->name('couleurs.store');
        Route::delete('couleurs/{couleur}', [CouleurController::class, 'destroy'])->name('couleurs.destroy');
    });
});
