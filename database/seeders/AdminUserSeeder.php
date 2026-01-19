<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
    if (!User::where('email', 'admin@example.com')->exists()) {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Zorg ervoor dat het wachtwoord gehashed is
            'email_verified_at' => now(),
        ]);
    }
}
}
