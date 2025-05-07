<?php

namespace Database\Seeders;

use App\Models\Bien_etre;
use App\Models\Chambre;
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
            'name' => 'Test User',
            'email' => 'test@example.com',
            'admin' => true,
        ]);
        Bien_etre::factory()->create([
            'nom' => 'Aloe Vera ',
            'img_path' => 'produits/alofa.jpg',
            'description' => 'Choix judidieux, frais et délicatement sucré',
            'disponible' => true,
        ]);
        Bien_etre::factory()->create([
            'nom' => 'Mixte pour tous',
            'img_path' => 'produits/malosi.jpg',
            'description' => 'Une formule au parfum masculin et féminin, simple et doux pour la peau',
            'disponible' => true,
        ]);
        Bien_etre::factory()->create([
            'nom' => 'Freedom Olofi Fine',
            'img_path' => 'produits/olofi.jpg',
            'description' => 'Une formule parfaite, idéal pour les massages',
            'disponible' => true,
        ]);
        Produit::factory()->create([
            'nom' => 'Aloe Vera gel',
            'prix' => '34.55',
            'bien_etre_id' => '3',
        ]);
        Produit::factory()->create([
            'nom' => 'Aloe MSM Gel',
            'prix' => '25.19',
            'bien_etre_id' => '3',
        ]);
        Produit::factory()->create([
            'nom' => 'Deep Cream',
            'prix' => '20.79',
            'bien_etre_id' => '3',
        ]);
        Produit::factory()->create([
            'nom' => 'Berry nectar',
            'prix' => '30.00',
            'bien_etre_id' => '1',
        ]);
        Produit::factory()->create([
            'nom' => 'Aloe Peaches',
            'prix' => '30.00',
            'bien_etre_id' => '1',
        ]);
        Produit::factory()->create([
            'nom' => 'Bee Honey',
            'prix' => '35.00',
            'bien_etre_id' => '2',
        ]);
        Chambre::factory()->create([
            'nom' => 'Escadrons',
            'img_path' => 'chambres/escadons.jpg',
            'nbr_personnes' => '2',
            'nbr_lit' => '1',
            'nbr_sdb' => '1',
            'date_debut' => '01-06-2025',
            'date_fin' => '06-06-2025',
            'prix' => '540',
            'jours' => '5',
            'disponible' => true,
            'description' => 'Chambres avec beaucoup de charme, près de la fenêtre et du côté jardin.',
        ]);
        Chambre::factory()->create([
            'nom' => 'Prince',
            'img_path' => 'chambres/prince.jpg',
            'nbr_personnes' => '2',
            'nbr_lit' => '1',
            'nbr_sdb' => '1',
            'date_debut' => '01-06-2025',
            'date_fin' => '06-06-2025',
            'prix' => '500',
            'jours' => '5',
            'disponible' => true,
            'description' => 'Chambre exceptionnelle qui vous redonnera énergie et vitalité pour atteindre une forme olympique.',
        ]);


        // ---------effaceer-------------------------------------------
        Bien_etre::factory()->create([
            'nom' => 'Faux',
            'img_path' => 'produits/olofi.jpg',
            'description' => 'Une formule parfaite, idéal pour les massages',
            'disponible' => false,
        ]);
        Bien_etre::factory()->create([
            'nom' => 'vrai',
            'img_path' => 'produits/olofi.jpg',
            'description' => 'Une formule parfaite, idéal pour les massages',
            'disponible' => true,
        ]);
        Produit::factory()->create([
            'nom' => 'Aloe MSM',
            'prix' => '50.19',
            'bien_etre_id' => '3',
        ]);
        Produit::factory()->create([
            'nom' => 'AloM',
            'prix' => '50.19',
            'bien_etre_id' => '3',
        ]);

        Chambre::factory()->create([
            'nom' => 'Pre',
            'img_path' => 'chambres/prince.jpg',
            'nbr_personnes' => '2',
            'nbr_lit' => '1',
            'nbr_sdb' => '1',
            'date_debut' => '01-06-2025',
            'date_fin' => '06-06-2025',
            'prix' => '500',
            'jours' => '5',
            'disponible' => true,
            'description' => 'Chambre exceptionnelle qui vous redonnera énergie et vitalité pour atteindre une forme olympique.',
        ]);


        Chambre::factory()->create([
            'nom' => 'Prce',
            'img_path' => 'chambres/prince.jpg',
            'nbr_personnes' => '2',
            'nbr_lit' => '1',
            'nbr_sdb' => '1',
            'date_debut' => '01-06-2025',
            'date_fin' => '06-06-2025',
            'prix' => '500',
            'jours' => '5',
            'disponible' => true,
            'description' => 'Chambre exceptionnelle qui vous redonnera énergie et vitalité pour atteindre une forme olympique.',
        ]);


        Chambre::factory()->create([
            'nom' => 'FAUX',
            'img_path' => 'chambres/prince.jpg',
            'nbr_personnes' => '2',
            'nbr_lit' => '1',
            'nbr_sdb' => '1',
            'date_debut' => '01-06-2025',
            'date_fin' => '06-06-2025',
            'prix' => '500',
            'jours' => '5',
            'disponible' => false,
            'description' => 'Chambre exceptionnelle qui vous redonnera énergie et vitalité pour atteindre une forme olympique.',
        ]);
        // ------------------------------------------------------------------
    }
}
