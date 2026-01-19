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
        $categories = [
            'School',
            'Werk',
            'Persoonlijk',
            'Gym',
            'Chillen',
        ];

        foreach ($categories as $categoryName) {
            if (!Category::where('name', $categoryName)->exists()) {
                Category::create(['name' => $categoryName]);
            }
        }
    }
}
