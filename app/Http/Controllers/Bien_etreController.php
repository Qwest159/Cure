<?php

namespace App\Http\Controllers;

use App\Models\Bien_etre;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Bien_etreController extends Controller
{
    public function index()
    {
        $jetstream = auth()->check() ? $this->getJetstreamInfo() : null;

        $produits = Bien_etre::all();

        // Retourner la vue avec les données


        return Inertia::render('Bien_etre', [
            'jetstream' => $jetstream,
            'produits' => $produits,
            'auth' => auth()->user(),
        ]);
    }
}
