<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class RemoveDuplicateCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:remove-duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verwijder dubbele categorieën uit de database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $duplicates = Category::select('name')
            ->groupBy('name')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            Category::where('name', $duplicate->name)->skip(1)->delete();
        }

        $this->info('Dubbele categorieën zijn verwijderd.');
    }
}
