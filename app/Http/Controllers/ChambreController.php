<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ChambreController extends Controller
{
    public function index()
    {
        $jetstream = auth()->check() ? $this->getJetstreamInfo() : null;

        // Retourner la vue avec les données


        return Inertia::render('Chambre', [
            'jetstream' => $jetstream,
            'auth' => auth()->user(),
        ]);
    }
}
