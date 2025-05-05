<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Lfclean;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;



class RajoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_Avant_Après()
    {

        Gate::authorize('viewAny', Lfclean::class);

        $imgAvant_Après = Image::where('section', 'imgAvant_Après')->get();

        return Inertia::render('Admin/Image/Avant_Après', [
            'imgAvant_Après' => $imgAvant_Après,
        ]);
    }
    public function index_Endroit_paysage()
    {
        Gate::authorize('viewAny', Lfclean::class);
        $imgEndroit_paysage = Image::where('section', 'imgEndroit_paysage')->get();


        return Inertia::render('Admin/Image/Endroit_paysage', [
            'imgEndroit_paysage' =>  $imgEndroit_paysage,
        ]);
    }
    public function index_Partenaire()
    {
        Gate::authorize('viewAny', Lfclean::class);
        $img_partenaire = Image::where('section', 'img_partenaire')->get();
        return Inertia::render('Admin/Image/Partenaire', [
            'img_partenaire' => $img_partenaire,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $section)
    {

        Gate::authorize('viewAny', Lfclean::class);
        $validatedData = $request->validate([
            'img_path' => 'required_without:img_path1|required_without:img_path2',
            'img_path1' => 'required_without:img_path',
            'img_path2' => 'required_without:img_path',

        ]);
        // $id permet de savoir qu'elle image on enregistre, 1= avant/apres 2= paysage 3 partenaire
        //passage de la route, l'id du ticket



        // vérifie les erreurs
        function verif_image($typimage, Request $request, $section)
        {

            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];


            if ($section === 'imgAvant_Après'   &&  count($request->file('img_path1')) !== 1) {
                return back()->with('error', "Maximum 1 image est acceptée.");
            }

            $taille_totale = 0;
            $max_totale = 15728640;
            $maxSize = 5242880; // Taille maximale en ko (5 Mo)
            if ($request->hasFile($typimage)) {
                for ($i = 0; $i < count($request->file($typimage)); $i++) {
                    // verif
                    $image = $request->file($typimage)[$i];

                    if (!$image->isValid()) {
                        return back()->with('error', "Type image demandée. Cette image n'est pas acceptée " . $image->getClientOriginalName());
                    }
                    $mimeType = $image->getMimeType();

                    if (!in_array($mimeType, $allowedMimeTypes)) {

                        return back()->with('error', "Les formats d'image acceptées sont : jpeg, png, jpg ,webp. Cette image n'est pas acceptée " . $image->getClientOriginalName());
                    }
                    // Vérification de la taille de l'image
                    if ($image->getSize() > $maxSize) {
                        return back()->with('error', "Taille de l'image trop grande : " . $image->getClientOriginalName());
                    }

                    $taille_totale += $image->getSize();
                    if ($taille_totale > $max_totale) { // Comparaison avec la taille limite en octets
                        return back()->with('error', "Trop d'images envoyées, limité à 15 Mo.");
                    }
                }
            };
        }

        // ici les sections === paysage,avant/apres,partenaire


        // ------AVANT APRES----

        if ($section === "imgAvant_Après") {
            $try = verif_image('img_path1', $request, $section);
            if ($try) {
                return $try;
            }
            $try2 = verif_image('img_path2', $request, $section);

            if ($try2) {
                return  $try2;
            }
            $image = Image::make();
            $image->section = $section;
            $image->img_path = $request->file('img_path1')[0]->store('imgAvant_Après', 'public');
            $image->img_path2 = $request->file('img_path2')[0]->store('imgAvant_Après', 'public');
            $image->save();
        } else {
            for ($i = 0; $i < count($request->file('img_path')); $i++) {

                $try = verif_image('img_path', $request, $section);
                if ($try) {
                    return $try;
                }

                $image = Image::make();
                $image->section = $section;
                $image->img_path = $request->file('img_path')[$i]->store($section, 'public');

                $image->save();
            }
        }

        return redirect()->back()->with('réussi', "Image Enregistrée");
    }
    public function destroy($id)
    {

        Gate::authorize('delete', Lfclean::class);

        $image = Image::findOrFail($id); // Récupère le client
        $image->delete();

        return redirect()->back()->with('réussi', "Image Effacée");
    }
}
