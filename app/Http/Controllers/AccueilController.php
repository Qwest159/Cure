<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AccueilController extends Controller
{
    public function index()
    {


        $jetstream = auth()->check() ? $this->getJetstreamInfo() : null;

        // Retourner la vue avec les données


        return Inertia::render('Accueil', [
            'jetstream' => $jetstream,
            'auth' => auth()->user(),
        ]);
    }
    public function  Données_personnelles()
    {
        $jetstream = auth()->check() ? $this->getJetstreamInfo() : null;

        return Inertia::render('Données_personnelles', [
            'jetstream' => $jetstream,
            'auth' => auth()->user(),
        ]);
    }
    public function  Mentions_légales()
    {
        $jetstream = auth()->check() ? $this->getJetstreamInfo() : null;
        return Inertia::render('Mentions_légales', [
            'jetstream' => $jetstream,
            'auth' => auth()->user(),
        ]);
    }
}
