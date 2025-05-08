<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\Admin\CureController;
use App\Http\Controllers\Admin\RajoutController;
use App\Http\Controllers\Bien_etreController;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\ContactController;
use App\Models\Chambre;

// ADMIN
use App\Http\Controllers\Admin\ChambreController as AdminChambreController;
use App\Http\Controllers\Admin\FormuleController as AdminFormuleController;
use App\Http\Controllers\Admin\ProduitController as AdminProduitController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', [AccueilController::class, 'index'])->name('accueil');

Route::get('/bien_etre', [Bien_etreController::class, 'index'])->name('bien_etre');
Route::get('/chambre', [ChambreController::class, 'index'])->name('chambre');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/Contact_post', [ContactController::class, 'envoyer_mail'])->name('mail.email');

// INFO DU SITE ET PERSONNELLE
Route::get('/Mentions_légales', [AccueilController::class, 'Mentions_légales'])->name('mentions_legales');
Route::get('/Données_personnelles', [AccueilController::class, 'Données_personnelles'])->name('donnees_personnelles');

// ----------PARTIE CHANGEMENT DE LIEN------------
Route::get('/connexion1234', [AuthenticatedSessionController::class, 'create'])
    ->middleware(['guest'])
    ->name('login');
Route::post('/connexion1234', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest']);


// -------------PARTIE CONNECTÉ--------------
Route::middleware([
    // 'auth:sanctum',
    // config('jetstream.auth_session'),
    // 'verified',
])->group(function () {

    Route::get('/cure_virginie', [CureController::class, 'index'])->name('cure_accueil');
    // ----- Chambre-----
    Route::get('/cure_chambre', [AdminChambreController::class, 'index'])->name('cure_chambre');
    Route::get('/cure_chambre/create', [AdminChambreController::class, "create"])->name('cure_chambre.create');
    Route::post('/cure_chambre/store', [AdminChambreController::class, "store"])->name('cure_chambre.store');
    Route::get('/cure_chambre/edit/{id}', [AdminChambreController::class, "edit"])->name('cure_chambre.edit');

    Route::post(
        '/cure_chambre/update/{Chambre}',
        [AdminChambreController::class, "update"]
    )->name('cure_chambre.update');
    Route::delete('/cure_chambre/destroy/{id}', [AdminChambreController::class, 'destroy'])->name('cure_chambre.destroy');






    // ----- Formule-----
    Route::get('/cure_formule', [AdminFormuleController::class, 'index'])->name('cure_formule');
    Route::get('/cure_formule/create', [AdminFormuleController::class, "create"])->name('cure_formule.create');
    Route::post('/cure_formule/store', [AdminFormuleController::class, "store"])->name('cure_formule.store');
    Route::get('/cure_formule/edit/{id}', [AdminFormuleController::class, "edit"])->name('cure_formule.edit');
    Route::post('/cure_formule/update/{formule}', [AdminFormuleController::class, "update"])->name('cure_formule.update');
    Route::delete('/cure_formule/destroy/{id}', [AdminFormuleController::class, 'destroy'])->name('cure_formule.destroy');




    // --------PRODUITS des formules------------
    Route::get('/cure_formule/edit/produit/{id}', [AdminFormuleController::class, "edit_produit"])->name('cure_formule.edit_produit');

    Route::post(
        '/cure_formule/update/produit/{id}',
        [AdminFormuleController::class, "update_produit"]
    )->name('cure_formule.update_produit');
    Route::delete('/cure_formule/destroy/produit/{id}/{id_produit}', [AdminFormuleController::class, 'destroy_produit'])->name('cure_formule.destroy_produit');



    // ------PRODUIT----------

    Route::get('/cure_produit', [AdminProduitController::class, 'index'])->name('cure_produit');
    Route::get('/cure_produit/create', [AdminProduitController::class, "create"])->name('cure_produit.create');
    Route::post('/cure_produit/store', [AdminProduitController::class, "store"])->name('cure_produit.store');
    Route::get('/cure_produit/edit/{id}', [AdminProduitController::class, "edit"])->name('cure_produit.edit');
    Route::post('/cure_produit/update/{produit}', [AdminProduitController::class, "update"])->name('cure_produit.update');
    Route::delete('/cure_produit/destroy/{id}', [AdminProduitController::class, 'destroy'])->name('cure_produit.destroy');
});
