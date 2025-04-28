<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $jetstream = auth()->check() ? $this->getJetstreamInfo() : null;

        return Inertia::render('Contact', [
            'jetstream' => $jetstream,
            'auth' => auth()->user(),
        ]);
    }
    public function envoyer_mail(Request $request)
    {

        $validatedData = $request->validate([
            'Nom' => 'required|string|max:30|min:2',
            'Email' => 'required|string|email|min:2',
            'Téléphone' => 'required|string|max:20|min:2',
            'Adresse' => 'required|string|max:255|min:2',
            'Code' => 'required|string|max:10|min:2',
            'Nettoyage' => 'required|string|in:Vitre/Véranda/Pergolas,panneaux,Panneaux photovoltaïques,Chantier,Terrasse,Façade',  // Ajoute toutes les options possibles
            'Habitat' => 'required|string|in:Maison,Immeuble',  // Remplacer par tes options
            'Fréquence' => 'nullable|string|in:Une fois,Trimestrielle,Je ne sais pas|required_if:Nettoyage,Vitre/Véranda/Pergolas,panneaux|required_if:Nettoyage,Chantier|required_if:Nettoyage,Terrasse',

            'Installation' => 'nullable|max:10|min:2|required_if:Nettoyage,Panneaux photovoltaïques',
            'Nombre' => 'nullable|integer|min:1|required_if:Nettoyage,Panneaux photovoltaïques',
            'images' => 'required',
            'Date' => 'required|date',
            'Heure' => 'required|date_format:H:i|in:08:00,09:00,10:00,16:00,17:00,18:00,19:00',  // Format de l'heure "HH:MM"
            'Commentaire' => 'nullable|string|max:150',  // Champ optionnel pour un commentaire
        ]);

        //nettoyage
        function netoyageCharactere($donnee)
        {
            $donnee = trim($donnee);
            $donnee =  htmlspecialchars($donnee);
            return $donnee;
        }




        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

        if (count($request->file('images')) > 5) {
            return back()->with('error', "Maximum 5 images sont acceptées.");
        }
        $taille_totale = 0;
        $max_totale = 15728640;
        $maxSize = 5242880; // Taille maximale en ko (5 Mo)
        if ($request->hasFile('images')) {
            for ($i = 0; $i < count($request->file('images')); $i++) {
                // verif
                $image = $request->file('images')[$i];
                if (!$image->isValid()) {
                    return back()->with('error', "Type image demandée. Cette image n'est pas acceptée " . netoyageCharactere($image->getClientOriginalName()));
                }
                $mimeType = $image->getMimeType();

                if (!in_array($mimeType, $allowedMimeTypes)) {
                    return back()->with('error', "Les formats d'image acceptées sont : jpeg, png, jpg ,webp. Cette image n'est pas acceptée " . netoyageCharactere($image->getClientOriginalName()));
                }
                // Vérification de la taille de l'image
                if ($image->getSize() > $maxSize) {
                    return back()->with('error', "Taille de l'image trop grande : " . netoyageCharactere($image->getClientOriginalName()));
                }

                $taille_totale += $image->getSize();
                if ($taille_totale > $max_totale) { // Comparaison avec la taille limite en octets
                    return back()->with('error', "Trop d'images envoyées, limité à 15 Mo.");
                }
                $imageStream = fopen($image->getRealPath(), 'r');
                $donnée["image"][$i] = [
                    'stream' => $imageStream,
                    'name' => $image->getClientOriginalName(), // Nom du fichier
                    'taille_totale' => $image->getSize(),
                ];
            }
        };

        // ------------DATE-------------

        function convertDate($date)
        {
            // Séparer la date en année, mois et jour
            list($year, $month, $day) = explode('-', $date);

            // Retourner la date au format DD.MM.YY
            return $day . '-' . $month . '-' . $year;
        }


        $date_nettoyée = netoyageCharactere($validatedData['Date']);
        if ($date_nettoyée <= date("Y-m-d")) {
            return back()->with('date', "La date " . convertDate($date_nettoyée) . " est invalide");
        }


        // -----HEURE ----
        $heure_nettoyée = netoyageCharactere($validatedData['Heure']);

        $plages_horaires = [
            "matin" => ["08:00", "09:00", "10:00"],
            "midi" => ["16:00", "17:00", "18:00", "19:00"]
        ];

        foreach ($plages_horaires as $periode => $heures) {
            if (in_array($heure_nettoyée, $heures, true)) {
                $heure_trouvée =  Heure::where([
                    ['date', '=', $date_nettoyée],
                    ['heure', '=', $periode]
                ])->first();
            }
        }

        if ($heure_trouvée === null) {
            Heure::create([
                'date' => $date_nettoyée,
                'heure' => $periode,
            ]);
        } else {
            return back()->with('heure', "L'heure vient tout juste d'être choisie, veuillez nous en excuser.");
        }


        $donnée["nom"] = netoyageCharactere($validatedData["Nom"]);
        $donnée["email"] = netoyageCharactere($validatedData["Email"]);
        $donnée["telephone"] = netoyageCharactere($validatedData["Téléphone"]);
        $donnée["adresse"] = netoyageCharactere($validatedData["Adresse"]);
        $donnée["code"] = netoyageCharactere($validatedData["Code"]);
        $donnée["nettoyage"] = netoyageCharactere($validatedData["Nettoyage"]);
        $donnée["habitat"] = netoyageCharactere($validatedData["Habitat"]);
        $donnée["frequence"] = netoyageCharactere($validatedData["Fréquence"]);
        $donnée["installation"] = netoyageCharactere($validatedData["Installation"]);
        $donnée["nombre"] = netoyageCharactere($validatedData["Nombre"]);

        $donnée["date"] = convertDate($date_nettoyée);
        $donnée["heure"] = netoyageCharactere($validatedData["Heure"]);
        $donnée["commentaire"] = netoyageCharactere($validatedData["Commentaire"]);
        // DETSINAIRE ICIIIIIIIIIIIIIIIIIIIIII

        if ($donnée["nom"] && $donnée["email"] && $donnée["telephone"] && $donnée["adresse"] && $donnée["code"] && $donnée["nettoyage"] && $donnée["habitat"] && $donnée['image'] && $donnée["date"] && $donnée["heure"]) {

            Mail::to('projet-php@qwesty.be')->send(new Email($donnée));

            foreach ($donnée['image'] as $image) {
                if (is_resource($image['stream'])) {
                    fclose($image['stream']);
                }
            }
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
