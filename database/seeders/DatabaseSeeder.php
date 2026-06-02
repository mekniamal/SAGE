<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Catégories cosmétiques
        $categories = [
            ['name' => 'Soins Visage', 'slug' => 'soins-visage', 'description' => 'Crèmes, sérums et soins spécialisés pour le visage'],
            ['name' => 'Corps', 'slug' => 'corps', 'description' => 'Produits de soin pour le corps entier'],
            ['name' => 'Cheveux', 'slug' => 'cheveux', 'description' => 'Shampoings, après-shampoings et traitements capillaires'],
            ['name' => 'Huiles Précieuses', 'slug' => 'huiles-precieuses', 'description' => 'Huiles essentielles et huiles précieuses'],
            ['name' => 'Maquillage', 'slug' => 'maquillage', 'description' => 'Produits de maquillage naturels et minéraux'],
            ['name' => 'Sets & Collections', 'slug' => 'sets-collections', 'description' => 'Collections complètes et sets spéciaux'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
