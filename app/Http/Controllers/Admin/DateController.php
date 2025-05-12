<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

use App\Models\Cure;
use App\Models\Date;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DateController extends Controller
{
    public function index()
    {

        Gate::authorize('viewAny', Cure::class);

        $dates = Date::all();

        return Inertia::render('Admin/Dates/Index', [
            'dates' => $dates,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        Gate::authorize('create', Cure::class);

        return Inertia::render('Admin/Dates/Create');
    }

    public function store(Request $request)
    {
        // Validation des données
        Gate::authorize('store', Cure::class);

        $validatedData = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'prix' => 'required|string|max:10|min:1',
            'jours' => 'required|string|max:10|min:1',
        ]);
        // Création et sauvegarde du date
        // ------------DATE-------------
        function convertDate($date)
        {
            // Séparer la date en année, mois et jour
            list($year, $month, $day) = explode('-', $date);

            // Retourner la date au format DD.MM.YY
            return $day . '-' . $month . '-' . $year;
        }

        $date = new Date();
        $date->date_debut = convertDate($validatedData['date_debut']);;
        $date->date_fin = convertDate($validatedData['date_fin']);
        $date->prix = $validatedData['prix'];
        $date->jours = $validatedData['jours'];
        $date->save();
        // Redirection
        return redirect()->back();
    }

    public function edit($id)
    {
        Gate::authorize('edit', Cure::class);

        $date = Date::findOrFail($id);

        function convertDate_system($date)
        {
            // Séparer la date en année, mois et jour
            list($day, $month, $year) = explode('-', $date);

            // Retourner la date au format DD.MM.YY
            return $year . '-' . $month . '-' . $day;
        }

        return Inertia::render('Admin/Dates/Edit', [
            'date' => $date,
            'date_fin' => convertDate_system($date['date_fin']),
            'date_debut' => convertDate_system($date['date_debut']),
        ]);
    }

    public function update(Request $request, Date $date)
    {
        Gate::authorize('update', Cure::class);

        $validatedData = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',

            'prix' => 'required|string|max:10|min:1',
            'jours' => 'required|string|max:10|min:1',
        ]);
        function convertDate_serv($date)
        {
            // Séparer la date en année, mois et jour
            list($year, $month, $day) = explode('-', $date);

            // Retourner la date au format DD.MM.YY
            return $day . '-' . $month . '-' . $year;
        }

        // Convertir et mettre à jour les dates
        $date->date_debut = convertDate_serv($validatedData['date_debut']);
        $date->date_fin = convertDate_serv($validatedData['date_fin']);
        $date->prix = $validatedData['prix'];
        $date->jours = $validatedData['jours'];
        // Sauvegarder les modifications dans la base de données
        $date->save();
        return redirect()->back();
    }
    public function destroy($id)
    {
        Gate::authorize('destroy', Cure::class);
        $date = Date::findOrFail($id);
        $date->delete();
        return redirect()->back();
    }
}
