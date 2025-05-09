<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\Chambre;
use App\Models\Cure;

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

        $chambres = Chambre::all();

        return Inertia::render('Admin/Chambres/Index', [
            'chambres' => $chambres,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return Inertia::render('Admin/Chambres/Create');
    }

    public function store(Request $request)
    {
        // Validation des données

        $validatedData = $request->validate([
            'nom' => 'required|string|max:15|min:1',
            'img_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nbr_personnes' => 'required|string|max:5|min:1',
            'nbr_lit' => 'required|string|max:5|min:1',
            'nbr_sdb' => 'required|string|max:5|min:1',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'prix' => 'required|string|max:10|min:1',
            'jours' => 'required|string|max:10|min:1',
            'description' => 'required|string|max:150',
        ]);


        // ------------DATE-------------

        function convertDate($date)
        {
            // Séparer la date en année, mois et jour
            list($year, $month, $day) = explode('-', $date);

            // Retourner la date au format DD.MM.YY
            return $day . '-' . $month . '-' . $year;
        }

        // Création et sauvegarde du Chambre

        $Chambre = new Chambre();
        $Chambre->nom = $validatedData['nom'];
        $Chambre->img_path = $request->file('img_path')->store('chambres', 'public');
        $Chambre->nbr_personnes = $validatedData['nbr_personnes'];
        $Chambre->nbr_lit = $validatedData['nbr_lit'];
        $Chambre->nbr_sdb = $validatedData['nbr_sdb'];
        $Chambre->date_debut = convertDate($validatedData['date_debut']);;
        $Chambre->date_fin = convertDate($validatedData['date_fin']);
        $Chambre->description = $validatedData['description'];
        $Chambre->prix = $validatedData['prix'];
        $Chambre->jours = $validatedData['jours'];
        $Chambre->save();

        // Redirection
        return redirect()->back();
    }

    public function edit($id)
    {
        // dd($Chambre);
        $Chambre = Chambre::findOrFail($id);

        function convertDate_system($date)
        {
            // Séparer la date en année, mois et jour
            list($day, $month, $year) = explode('-', $date);

            // Retourner la date au format DD.MM.YY
            return $year . '-' . $month . '-' . $day;
        }

        return Inertia::render('Admin/Chambres/Edit', [
            'chambre' => $Chambre,
            'date_fin' => convertDate_system($Chambre['date_fin']),
            'date_debut' => convertDate_system($Chambre['date_debut']),
        ]);
    }

    public function update(Request $request, Chambre $Chambre)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:15|min:1',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nbr_personnes' => 'required|string|max:5|min:1',
            'nbr_lit' => 'required|string|max:5|min:1',
            'nbr_sdb' => 'required|string|max:5|min:1',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'prix' => 'required|string|max:10|min:1',
            'jours' => 'required|string|max:10|min:1',
            'description' => 'required|string|max:150',
            'disponible' => 'required|boolean',

        ]);
        $Chambre->nom = $validatedData['nom'];

        // Si une nouvelle image est envoyée, mettre à jour le chemin de l'image
        if ($request->hasFile('img_path')) {
            $Chambre->img_path = $request->file('img_path')->store('chambres', 'public');
        }

        $Chambre->nbr_personnes = $validatedData['nbr_personnes'];
        $Chambre->nbr_lit = $validatedData['nbr_lit'];
        $Chambre->nbr_sdb = $validatedData['nbr_sdb'];


        function convertDate_serv($date)
        {
            // Séparer la date en année, mois et jour
            list($year, $month, $day) = explode('-', $date);

            // Retourner la date au format DD.MM.YY
            return $day . '-' . $month . '-' . $year;
        }

        // Convertir et mettre à jour les dates
        $Chambre->date_debut = convertDate_serv($validatedData['date_debut']);
        $Chambre->date_fin = convertDate_serv($validatedData['date_fin']);

        $Chambre->description = $validatedData['description'];
        $Chambre->prix = $validatedData['prix'];
        $Chambre->jours = $validatedData['jours'];
        $Chambre->disponible = $validatedData['disponible'];

        // Sauvegarder les modifications dans la base de données
        $Chambre->save();

        return redirect()->back();
    }
    public function destroy($id)
    {
        // Gate::authorize('delete', $article);
        $Chambre = Chambre::findOrFail($id);
        $Chambre->delete();

        return redirect()->back();
    }
}
