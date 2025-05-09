<?php

namespace App\Http\Controllers;

use App\Mail\Email;
use App\Models\Bien_etre;
use App\Models\Chambre;
use Illuminate\Mail\Mailable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $jetstream = auth()->check() ? $this->getJetstreamInfo() : null;

        $chambre_dispo = Chambre::select("id", "nom", "date_debut", "date_fin", "prix")
            ->where("disponible", true)
            ->get();

        $formules = Bien_etre::with('produits')->where("disponible", true)
            ->get();


        return Inertia::render('Contact', [
            'jetstream' => $jetstream,
            'chambre_dispo' => $chambre_dispo,
            'formules' => $formules,
            'auth' => auth()->user(),
        ]);
    }
    public function envoyer_mail(Request $request)
    {

        $validatedData = $request->validate([
            'nom' => 'required|string|min:2|max:30',
            'prénom' => 'required|string|min:2|max:30',
            'email' => 'required|email|max:255',
            'téléphone' => 'required|string|min:6|max:20',
            'nombres' => 'required|integer|min:1|max:10',
            'chambre' => 'required',
            'cure' => 'required|string|in:Oui,Non',
            'formule1' => 'nullable|string|required_if:Cure,Oui',
            'formule2' => 'nullable|string',
            'commentaire' => 'nullable|string|max:200|min:5',
        ]);

        function netoyageCharactere($donnee_input)
        {
            $donnee = trim($donnee_input);
            // ENT_COMPAT => évite de transformer le ' en caractère
            $donnee_final =  htmlspecialchars($donnee, ENT_COMPAT);
            return $donnee_final;
        }
        $tableau_données_nettoyées = [];
        foreach ($validatedData as $key => $value) {
            $tableau_données_nettoyées[$key] = netoyageCharactere($value);
        }

        // dd($tableau_données_nettoyées);


        // ------------DATE-------------

        // function convertDate($date)
        // {
        //     // Séparer la date en année, mois et jour
        //     list($year, $month, $day) = explode('-', $date);

        //     // Retourner la date au format DD.MM.YY
        //     return $day . '-' . $month . '-' . $year;
        // }


        // $date_nettoyée = netoyageCharactere($validatedData['Date']);
        // if ($date_nettoyée <= date("Y-m-d")) {
        //     return back()->with('date', "La date " . convertDate($date_nettoyée) . " est invalide");
        // }
        // DETSINAIRE ICIIIIIIIIIIIIIIIIIIIIII

        if ($tableau_données_nettoyées) {
            Mail::to('projet-php@qwesty.be')->send(new Email($tableau_données_nettoyées));
        }




        redirect()->back();


        // foreach ($donnée['image'] as $imagePath) {
        //     Storage::delete($imagePath);
        // }


        // if ($request->hasFile('images')) {
        //     for ($i = 0; $i < count($request->file('images')); $i++) {
        //         $image = Image_temp::make();
        //         $path = $request->file('images')[$i]->store('images', 'public');

        //         // Enregistre le chemin de l'image dans la base de données
        //         $image->img_path = $path;

        //         $donnée["image"][$i] = $path;
        //         $image->save();
        //     }
        // }


        // Mail::to('projet-php@qwesty.be')->send(new Email($donnée));
    }
}
