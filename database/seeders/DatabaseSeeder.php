<?php

namespace Database\Seeders;

use App\Models\Bien_etre;
use App\Models\Chambre;
use App\Models\Chambre_date;
use App\Models\Date;
use App\Models\FormuleProduit;
use App\Models\Produit;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        User::factory()->create([
            'name' => 'Virginie',
            'email' => 'virginiecure9@email.com',
            'admin' => true,
        ]);


        Bien_etre::factory()->create([
            'nom' => 'Aloe Vera ',
            'img_path' => 'produits/alofa.webp',
            'description' => 'Choix judidieux, frais et délicatement sucré',
            'disponible' => true,
        ]);
        Bien_etre::factory()->create([
            'nom' => 'Mixte pour tous',
            'img_path' => 'produits/malosi.webp',
            'description' => 'Une formule au parfum masculin et féminin, simple et doux pour la peau',
            'disponible' => true,
        ]);
        Bien_etre::factory()->create([
            'nom' => 'Freedom Olofi Fine',
            'img_path' => 'produits/olofi.webp',
            'description' => 'Une formule parfaite, idéal pour les massages',
            'disponible' => true,
        ]);
        Produit::factory()->create([
            'nom' => 'Aloe Vera gel',
            'prix' => '34,55',
        ]);
        Produit::factory()->create([
            'nom' => 'Aloe MSM Gel',
            'prix' => '25,19',
        ]);
        Produit::factory()->create([
            'nom' => 'Deep Cream',
            'prix' => '20,79',
        ]);
        Produit::factory()->create([
            'nom' => 'Berry nectar',
            'prix' => '30,00',
        ]);
        Produit::factory()->create([
            'nom' => 'Aloe Peaches',
            'prix' => '30,00',
        ]);
        Produit::factory()->create([
            'nom' => 'Bee Honey',
            'prix' => '35,00',
        ]);
        Chambre::factory()->create([
            'nom' => 'Escadrons',
            'img_path' => 'chambres/escadons.webp',
            'nbr_personnes' => '2',
            'nbr_lit' => '1',
            'nbr_sdb' => '1',
            'description' => 'Chambres avec beaucoup de charme, près de la fenêtre, côté jardin.',
            'disponible' => true,

        ]);
        Chambre::factory()->create([
            'nom' => 'Prince',
            'img_path' => 'chambres/prince.webp',
            'nbr_personnes' => '2',
            'nbr_lit' => '1',
            'nbr_sdb' => '1',
            'description' => 'Chambre exceptionnelle qui vous redonnera énergie et vitalité pour atteindre une forme olympique.',
            'disponible' => true,

        ]);
        FormuleProduit::factory()->create([
            'bien_etre_id' => 1,
            'produit_id' => 1,
        ]);
        FormuleProduit::factory()->create([
            'bien_etre_id' => 1,
            'produit_id' => 2,
        ]);
        FormuleProduit::factory()->create([
            'bien_etre_id' => 1,
            'produit_id' => 3,
        ]);
        FormuleProduit::factory()->create([
            'bien_etre_id' => 1,
            'produit_id' => 4,
        ]);
        FormuleProduit::factory()->create([
            'bien_etre_id' => 1,
            'produit_id' => 5,
        ]);
        FormuleProduit::factory()->create([
            'bien_etre_id' => 2,
            'produit_id' => 1,
        ]);
        FormuleProduit::factory()->create([
            'bien_etre_id' => 2,
            'produit_id' => 2,
        ]);
        FormuleProduit::factory()->create([
            'bien_etre_id' => 2,
            'produit_id' => 3,
        ]);
        FormuleProduit::factory()->create([
            'bien_etre_id' => 3,
            'produit_id' => 4,
        ]);
        FormuleProduit::factory()->create([
            'bien_etre_id' => 3,
            'produit_id' => 5,
        ]);



        Date::factory()->create([
            'date_debut' => '02-06-2025',
            'date_fin' => '06-06-2025',
            'jours' => '5',
            'prix' => '500,00',
        ]);
        Date::factory()->create([
            'date_debut' => '10-06-2025',
            'date_fin' => '14-06-2025',
            'jours' => '5',
            'prix' => '540,00',
        ]);
        Date::factory()->create([
            'date_debut' => '02-07-2025',
            'date_fin' => '06-07-2025',
            'jours' => '5',
            'prix' => '600,00',
        ]);
        Date::factory()->create([
            'date_debut' => '10-07-2025',
            'date_fin' => '14-07-2025',
            'jours' => '5',
            'prix' => '640,00',
        ]);


        Chambre_date::factory()->create([
            'chambre_id' => '1',
            'date_id' => '1',
        ]);
        Chambre_date::factory()->create([
            'chambre_id' => '2',
            'date_id' => '1',
        ]);
        Chambre_date::factory()->create([
            'chambre_id' => '1',
            'date_id' => '2',
        ]);
        Chambre_date::factory()->create([
            'chambre_id' => '2',
            'date_id' => '2',
        ]);
        Chambre_date::factory()->create([
            'chambre_id' => '1',
            'date_id' => '3',
        ]);
        Chambre_date::factory()->create([
            'chambre_id' => '1',
            'date_id' => '4',
        ]);

        // ---------effaceer-------------------------------------------
        Produit::factory()->create([
            'nom' => 'Aloe MSM',
            'prix' => '50,19',
        ]);
        Produit::factory()->create([
            'nom' => 'AloM',
            'prix' => '50,19',
        ]);

        // ------------------------------------------------------------------
    }
}
