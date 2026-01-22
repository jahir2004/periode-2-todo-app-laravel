<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use App\Models\Category;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Zorg ervoor dat er een gebruiker bestaat
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Zorg ervoor dat er een categorie bestaat
        $category = Category::firstOrCreate(
            ['name' => 'Algemeen'],
            ['description' => 'Standaard categorie']
        );

        // Voeg enkele specifieke taken toe
        Task::create([
            'title' => 'Eerste taak',
            'description' => 'Beschrijving van de eerste taak',
            'status' => 'todo',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        Task::create([
            'title' => 'Tweede taak',
            'description' => 'Beschrijving van de tweede taak',
            'status' => 'in_progress',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        Task::create([
            'title' => 'Derde taak',
            'description' => 'Beschrijving van de derde taak',
            'status' => 'done',
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
    }
}
