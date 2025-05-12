<?php

namespace App\Http\Controllers;

use App\Models\Chambre;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChambreController extends Controller
{
    public function index()
    {
        $jetstream = auth()->check() ? $this->getJetstreamInfo() : null;
        $chambres = Chambre::with(['dates'])->get();



        // Retourner la vue avec les données


        return Inertia::render('Chambre', [
            'jetstream' => $jetstream,
            'chambres' => $chambres,
            'auth' => auth()->user(),
        ]);
    }
}
