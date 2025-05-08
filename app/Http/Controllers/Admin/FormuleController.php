<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\Bien_etre;
use App\Models\Cure;
use App\Models\FormuleProduit;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;



class FormuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        Gate::authorize('viewAny', Cure::class);

        $formules = Bien_etre::with('produits')->get();

        return Inertia::render('Admin/Formules/Index', [
            'formules' => $formules,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return Inertia::render('Admin/Formules/Create');
    }

    public function store(Request $request)
    {
        // Validation des données

        $validatedData = $request->validate([
            'nom' => 'required|string|max:15|min:1',
            'img_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string|max:150',
        ]);


        // Création et sauvegarde d'une formule

        $formule = new Bien_etre();
        $formule->nom = $validatedData['nom'];
        $formule->img_path = $request->file('img_path')->store('produits', 'public');
        $formule->description = $validatedData['description'];
        $formule->save();

        // Redirection
        return redirect()->back();
    }

    public function edit($id)
    {

        $formule = Bien_etre::with('produits')->findOrFail($id);
        return Inertia::render('Admin/Formules/Edit', [
            'formule' => $formule,
        ]);
    }

    public function update(Request $request, Bien_etre $formule)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:15|min:1',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'disponible' => 'required|boolean',
            'description' => 'required|string|max:150',
        ]);
        $formule->nom = $validatedData['nom'];

        // Si une nouvelle image est envoyée, mettre à jour le chemin de l'image
        if ($request->hasFile('img_path')) {
            $formule->img_path = $request->file('img_path')->store('produits', 'public');
        }


        $formule->description = $validatedData['description'];
        $formule->disponible = $validatedData['disponible'];

        // Sauvegarder les modifications dans la base de données
        $formule->save();

        return redirect()->back();
    }
    public function destroy($id)
    {
        // Gate::authorize('delete', $article);
        $formule = Bien_etre::findOrFail($id);
        $formule->delete();

        return redirect()->back();
    }





    public function edit_produit($id)
    {

        $formule = Bien_etre::with('produits')->findOrFail($id);
        $produits = Produit::all();
        return Inertia::render('Admin/Formules/EditProduit', [
            'formule' => $formule,
            'produits' => $produits,
        ]);
    }

    public function update_produit(Request $request, $id_formule)
    {
        $validatedData = $request->validate([
            'produit' => 'required',
        ]);
        $formule_pivot = new FormuleProduit();
        $formule_pivot->bien_etre_id =  $id_formule;
        $formule_pivot->produit_id = $validatedData['produit'];

        $formule_pivot->save();

        return redirect()->back();
    }
    public function destroy_produit($id, $id_produit)
    {

        $formule = FormuleProduit::where('bien_etre_id', $id)->where('produit_id', $id_produit)->first();
        $formule->delete();
        return redirect()->back();
    }
}
