<?php

namespace App\Http\Controllers;

use App\Models\Bien_etre;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccueilController extends Controller
{
    public function index()
    {


        $jetstream = auth()->check() ? $this->getJetstreamInfo() : null;

        $formules = Bien_etre::inRandomOrder()->select('id', 'img_path', 'nom')->where("disponible", true)
            ->limit(3)
            ->get();

        return Inertia::render('Accueil', [
            'jetstream' => $jetstream,
            'formules' =>  $formules,
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
