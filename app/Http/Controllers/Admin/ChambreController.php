<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\Chambre;
use App\Models\Chambre_date;
use App\Models\Cure;
use App\Models\Date;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;



class ChambreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        Gate::authorize('viewAny', Cure::class);
        $chambres = Chambre::with('dates')->get();
        return Inertia::render('Admin/Chambres/Index', [
            'chambres' => $chambres,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        Gate::authorize('create', Cure::class);

        return Inertia::render('Admin/Chambres/Create');
    }

    public function store(Request $request)
    {
        // Validation des données
        Gate::authorize('store', Cure::class);

        $validatedData = $request->validate([
            'nom' => 'required|string|max:15|min:1',
            'img_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nbr_personnes' => 'required|string|max:5|min:1',
            'nbr_lit' => 'required|string|max:5|min:1',
            'nbr_sdb' => 'required|string|max:5|min:1',
            'description' => 'required|string|max:150',
        ]);

        // Création et sauvegarde du Chambre

        $Chambre = new Chambre();
        $Chambre->nom = $validatedData['nom'];
        $Chambre->img_path = $request->file('img_path')->store('chambres', 'public');
        $Chambre->nbr_personnes = $validatedData['nbr_personnes'];
        $Chambre->nbr_lit = $validatedData['nbr_lit'];
        $Chambre->nbr_sdb = $validatedData['nbr_sdb'];
        $Chambre->description = $validatedData['description'];
        $Chambre->save();

        // Redirection
        return redirect()->back();
    }

    public function edit($id)
    {
        Gate::authorize('edit', Cure::class);

        // dd($Chambre);
        $Chambre = Chambre::findOrFail($id);

        return Inertia::render('Admin/Chambres/Edit', [
            'chambre' => $Chambre,
        ]);
    }

    public function update(Request $request, Chambre $Chambre)
    {
        Gate::authorize('update', Cure::class);

        $validatedData = $request->validate([
            'nom' => 'required|string|max:15|min:1',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nbr_personnes' => 'required|string|max:5|min:1',
            'nbr_lit' => 'required|string|max:5|min:1',
            'nbr_sdb' => 'required|string|max:5|min:1',
            'description' => 'required|string|max:150',
            // 'disponible' => 'required|boolean',

        ]);
        $Chambre->nom = $validatedData['nom'];

        // Si une nouvelle image est envoyée, mettre à jour le chemin de l'image
        if ($request->hasFile('img_path')) {
            $Chambre->img_path = $request->file('img_path')->store('chambres', 'public');
        }

        $Chambre->nbr_personnes = $validatedData['nbr_personnes'];
        $Chambre->nbr_lit = $validatedData['nbr_lit'];
        $Chambre->nbr_sdb = $validatedData['nbr_sdb'];;
        $Chambre->description = $validatedData['description'];
        // $Chambre->disponible = $validatedData['disponible'];

        // Sauvegarder les modifications dans la base de données
        $Chambre->save();

        return redirect()->back();
    }
    public function destroy($id)
    {
        Gate::authorize('destroy', Cure::class);

        // Gate::authorize('delete', $article);
        $Chambre = Chambre::findOrFail($id);
        $Chambre->delete();

        return redirect()->back();
    }




    // -------------Date des chambres -------------


    public function edit_date($id)
    {

        $chambre = Chambre::select('id', 'nom')->with('dates')->findOrFail($id);
        $dates = Date::all();
        return Inertia::render('Admin/Chambres/EditDate', [
            'chambre' =>  $chambre,
            'dates' =>  $dates,
        ]);
    }

    public function update_date(Request $request, $id_chambre)
    {
        $validatedData = $request->validate([
            'date_id' => 'required',
        ]);
        $formule_pivot = new Chambre_date();
        $formule_pivot->chambre_id =  $id_chambre;
        $formule_pivot->date_id = $validatedData['date_id'];

        $formule_pivot->save();

        return redirect()->back();
    }
    public function destroy_date($chambre_id, $date_id)
    {

        $chambre_date = Chambre_date::where('chambre_id', $chambre_id)->where('date_id', $date_id)->first();
        $chambre_date->delete();
        return redirect()->back();
    }
}
