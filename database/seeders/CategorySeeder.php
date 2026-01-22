<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Algemeen',
            'description' => 'Standaard categorie',
        ]);

        Category::create([
            'name' => 'Werk',
            'description' => 'Categorie voor werkgerelateerde taken',
        ]);

        Category::create([
            'name' => 'Persoonlijk',
            'description' => 'Categorie voor persoonlijke taken',
        ]);
    }
}
