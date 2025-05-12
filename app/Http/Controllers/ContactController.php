<?php

namespace App\Http\Controllers;

use App\Mail\Email;
use App\Models\Bien_etre;
use App\Models\Chambre;
use App\Models\Date;
use Illuminate\Mail\Mailable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $jetstream = auth()->check() ? $this->getJetstreamInfo() : null;



        $chambre_dispo = Chambre::select("id", "nom")->with(['dates'])->get();

        $dates = Date::all();

        $formules = Bien_etre::with('produits')->where("disponible", true)
            ->get();


        return Inertia::render('Contact', [
            'jetstream' => $jetstream,
            'chambre_dispo' => $chambre_dispo,
            'formules' => $formules,
            'dates' => $dates,
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
            'date' => 'required',
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


        if ($tableau_données_nettoyées) {
            Mail::to('projet-php@qwesty.be')->send(new Email($tableau_données_nettoyées));
        }

        redirect()->back();
    }
}
