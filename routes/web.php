<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\Admin\CureController;
use App\Http\Controllers\Bien_etreController;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\ContactController;
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
    Route::get('/cure_chambre', [RajoutController::class, 'chambre'])->name('cure_chambre');


    // //image
    // Route::get('/lfclean_paysage', [ImageController::class, 'index_Endroit_paysage'])->name('lfclean_paysage');
    // Route::get('/lfclean_partenaire', [ImageController::class, 'index_Partenaire'])->name('lfclean_partenaire');
    // Route::post('/lfclean_store/{section}', [ImageController::class, 'store'])->name('lfclean_store');
    // Route::delete('/lfclean_destroy_image/{id}', [ImageController::class, 'destroy'])->name('lfclean.destroy');

    // //job
    // Route::get('/lfclean_jobcreate_index', [TravailController::class, 'index'])->name('lfclean_create_job');
    // Route::post('/lfclean_jobcreate_store', [TravailController::class, 'store'])->name('lfclean_store_job');
    // Route::delete('/lfclean_destroy/{id}', [TravailController::class, 'destroy'])->name('lfclean_destroy_job');

});
