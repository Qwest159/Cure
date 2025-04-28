<?php

namespace Database\Seeders;

use App\Models\Bien_etre;
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
    }
}
