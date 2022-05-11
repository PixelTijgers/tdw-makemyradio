<?php

// Namespacing.
namespace Database\Seeders;

// Facades.
use Illuminate\Database\Seeder;

// Models.
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Podcast',
            ],
            [
                'name' => 'Livestream',
            ],
            [
                'name' => 'Radio',
            ],
        ];

        foreach($categories as $category)
            Category::create($category);
    }
}
