<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\Bien_etre;
use App\Models\Cure;

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

        $formules = Bien_etre::all();

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
            'nbr_personnes' => 'required|string|max:5|min:1',
            'nbr_lit' => 'required|string|max:5|min:1',
            'nbr_sdb' => 'required|string|max:5|min:1',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'prix' => 'required|string|max:10|min:1',
            'jours' => 'required|string|max:10|min:1',
            'description' => 'required|string|max:150',
        ]);

        //nettoyage
        function netoyageCharactere($donnee)
        {
            $donnee = trim($donnee);
            $donnee =  htmlspecialchars($donnee);
            return $donnee;
        }
        // ------------DATE-------------

        function convertDate($date)
        {
            // Séparer la date en année, mois et jour
            list($year, $month, $day) = explode('-', $date);

            // Retourner la date au format DD.MM.YY
            return $day . '-' . $month . '-' . $year;
        }

        // Création et sauvegarde d'une formule

        $formule = new Bien_etre();
        $formule->nom = $validatedData['nom'];
        $formule->img_path = $request->file('img_path')->store('produits', 'public');
        $formule->nbr_personnes = $validatedData['nbr_personnes'];
        $formule->nbr_lit = $validatedData['nbr_lit'];
        $formule->nbr_sdb = $validatedData['nbr_sdb'];
        $formule->date_debut = convertDate($validatedData['date_debut']);;
        $formule->date_fin = convertDate($validatedData['date_fin']);
        $formule->description = $validatedData['description'];
        $formule->prix = $validatedData['prix'];
        $formule->jours = $validatedData['jours'];
        $formule->save();

        // Redirection
        return redirect()->back();
    }

    public function edit($id)
    {

        $formule = Bien_etre::findOrFail($id);

        function convertDate_system($date)
        {
            // Séparer la date en année, mois et jour
            list($day, $month, $year) = explode('-', $date);

            // Retourner la date au format DD.MM.YY
            return $year . '-' . $month . '-' . $day;
        }

        return Inertia::render('Admin/Formules/Edit', [
            'formule' => $formule,
        ]);
    }

    public function update(Request $request, Bien_etre $formule)
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
        ]);
        $formule->nom = $validatedData['nom'];

        // Si une nouvelle image est envoyée, mettre à jour le chemin de l'image
        if ($request->hasFile('img_path')) {
            $formule->img_path = $request->file('img_path')->store('produits', 'public');
        }

        $formule->nbr_personnes = $validatedData['nbr_personnes'];
        $formule->nbr_lit = $validatedData['nbr_lit'];
        $formule->nbr_sdb = $validatedData['nbr_sdb'];


        function convertDate_serv($date)
        {
            // Séparer la date en année, mois et jour
            list($year, $month, $day) = explode('-', $date);

            // Retourner la date au format DD.MM.YY
            return $day . '-' . $month . '-' . $year;
        }

        // Convertir et mettre à jour les dates
        $formule->date_debut = convertDate_serv($validatedData['date_debut']);
        $formule->date_fin = convertDate_serv($validatedData['date_fin']);

        $formule->description = $validatedData['description'];
        $formule->prix = $validatedData['prix'];
        $formule->jours = $validatedData['jours'];

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
}
