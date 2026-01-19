<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Zorg ervoor dat er een gebruiker bestaat
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'], // Zoek alleen op e-mail
            [
                'name' => 'Test User', // Stel deze velden alleen in als de gebruiker wordt aangemaakt
                'password' => bcrypt('password'),
            ]
        );

        // Voeg alleen taken toe
        Task::create([
            'title' => 'Eerste taak',
            'description' => 'Beschrijving van de eerste taak',
            'status' => 'todo',
            'user_id' => $user->id, // Verwijs naar de gebruiker
            'category_id' => 1, // Standaard categorie
        ]);

        Task::create([
            'title' => 'Tweede taak',
            'description' => 'Beschrijving van de tweede taak',
            'status' => 'in_progress',
            'user_id' => $user->id, // Verwijs naar de gebruiker
            'category_id' => 1, // Standaard categorie
        ]);

        Task::create([
            'title' => 'Derde taak',
            'description' => 'Beschrijving van de derde taak',
            'status' => 'done',
            'user_id' => $user->id, // Verwijs naar de gebruiker
            'category_id' => 1, // Standaard categorie
        ]);

        for ($i = 1; $i <= 10; $i++) {
            Task::create([
                'title' => "Taak $i",
                'description' => "Beschrijving van taak $i",
                'status' => 'todo',
                'user_id' => 1, // Zorg ervoor dat deze gebruiker bestaat
                'category_id' => 1, // Zorg ervoor dat deze categorie bestaat
            ]);
        }
    }
}
