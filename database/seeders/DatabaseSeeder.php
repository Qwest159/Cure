<?php

namespace Database\Seeders;

use App\Models\Bien_etre;
use App\Models\Chambre;
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
            'nom' => 'Forever Alofa Fine',
            'img_path' => 'produits/alofa.jpg',
            'litre' => '30',
            'prix' => '45,13',
            'description' => 'Un parfum unique, frais et délicatement sucré',
        ]);
        Bien_etre::factory()->create([
            'nom' => 'Forever Malosi Fine',
            'img_path' => 'produits/malosi.jpg',
            'litre' => '30',
            'prix' => '45,13',
            'description' => 'Un parfum masculin, simple et doux pour la peau',
        ]);
        Bien_etre::factory()->create([
            'nom' => 'Forever Olofi Fine',
            'img_path' => 'produits/olofi.jpg',
            'litre' => '30',
            'prix' => '45,13',
            'description' => 'Une crème parfaite, idéal pour les massages',
        ]);
        Chambre::factory()->create([
            'nom' => 'Escadons',
            'img_path' => 'chambres/escadons.jpg',
            'nbr_personnes' => '2',
            'nbr_lit' => '1',
            'nbr_sdb' => '1',
            'date_debut' => '01-06-25',
            'date_fin' => '06-06-25',
            'prix' => '540',
            'jours' => '5',
            'disponible' => '5',
            'description' => 'Chambres avec beaucoup de charme, près de la fenêtre et du côté jardin.',
        ]);
        Chambre::factory()->create([
            'nom' => 'Escadons',
            'img_path' => 'chambres/prince.jpg',
            'nbr_personnes' => '2',
            'nbr_lit' => '1',
            'nbr_sdb' => '1',
            'date_debut' => '01-06-25',
            'date_fin' => '06-06-25',
            'prix' => '540',
            'jours' => '5',
            'disponible' => '5',
            'description' => 'Chambre exceptionnelle qui vous redonnera énergie et vitalité pour atteindre une forme olympique.',
        ]);
    }
}
