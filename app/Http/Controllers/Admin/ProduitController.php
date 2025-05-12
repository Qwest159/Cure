<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\Cure;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;



class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        Gate::authorize('viewAny', Cure::class);

        $produits = Produit::all();

        return Inertia::render('Admin/Produits/Index', [
            'produits' => $produits,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return Inertia::render('Admin/Produits/Create');
    }

    public function store(Request $request)
    {
        // Validation des données

        $validatedData = $request->validate([
            'nom' => 'required|string|max:15|min:1',
            'prix' => 'required|string|max:10|min:1',
        ]);



        // Création et sauvegarde du Produit

        $produit = new Produit();
        $produit->nom = $validatedData['nom'];
        $produit->prix = $validatedData['prix'];
        $produit->save();
        // Redirection
        return redirect()->back();
    }

    public function edit($id)
    {

        $produit = Produit::findOrFail($id);

        return Inertia::render('Admin/Produits/Edit', [
            'produit' => $produit,
        ]);
    }

    public function update(Request $request, Produit $produit)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:15|min:1',
            'prix' => 'required|string|max:10|min:1',
        ]);
        $produit->nom = $validatedData['nom'];
        $produit->prix = $validatedData['prix'];

        // Sauvegarder les modifications dans la base de données
        $produit->save();

        return redirect()->back();
    }
    public function destroy($id)
    {
        // Gate::authorize('delete', $article);
        $produit = Produit::findOrFail($id);
        $produit->delete();
        return redirect()->back();
    }
}
