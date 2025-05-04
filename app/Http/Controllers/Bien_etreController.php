<?php

namespace App\Http\Controllers;

use App\Models\Bien_etre;
use App\Models\Produit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Bien_etreController extends Controller
{
    public function index()
    {
        $jetstream = auth()->check() ? $this->getJetstreamInfo() : null;

        $formules = Bien_etre::with('produits')->where("disponible", true)
            ->get();


        return Inertia::render('Bien_etre', [
            'jetstream' => $jetstream,
            'formules' => $formules,
            'auth' => auth()->user(),
        ]);
    }
}
