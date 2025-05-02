<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\Bien_etreController;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\ContactController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', [AccueilController::class, 'index'])->name('accueil');

Route::get('/bien_etre', [Bien_etreController::class, 'index'])->name('bien_etre');
Route::get('/chambre', [ChambreController::class, 'index'])->name('chambre');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/Contact_post', [ContactController::class, 'envoyer_mail'])->name('mail.email');

// INFO DU SITE ET PERSONNELLE
Route::get('/Mentions_légales', [AccueilController::class, 'Mentions_légales'])->name('mentions_legales');
Route::get('/Données_personnelles', [AccueilController::class, 'Données_personnelles'])->name('donnees_personnelles');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
