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
    Route::post('/cure_chambre/update/{Chambre}', [AdminChambreController::class, "update"])->name('cure_chambre.update');
    Route::delete('/cure_chambre/detsroy/{id}', [AdminChambreController::class, 'destroy'])->name('cure_chambre.destroy');


    // ----- Formule-----
    Route::get('/cure_formule', [AdminFormuleController::class, 'index'])->name('cure_formule');
    Route::get('/cure_formule/create', [AdminFormuleController::class, "create"])->name('cure_formule.create');
    Route::post('/cure_formule/store', [AdminFormuleController::class, "store"])->name('cure_formule.store');
    Route::get('/cure_formule/edit/{id}', [AdminFormuleController::class, "edit"])->name('cure_formule.edit');
    Route::post('/cure_formule/update/{formule}', [AdminFormuleController::class, "update"])->name('cure_formule.update');
    Route::delete('/cure_formule/detsroy/{id}', [AdminFormuleController::class, 'destroy'])->name('cure_formule.destroy');
});
