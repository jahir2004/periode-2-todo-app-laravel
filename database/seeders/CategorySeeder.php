<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // Add this import

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'School']);
        Category::create(['name' => 'Werk']);
        Category::create(['name' => 'Persoonlijk']);
        Category::create(['name' => 'Gym']);
        Category::create(['name' => 'Chillen']);
    }
}
