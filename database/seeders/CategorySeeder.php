<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement('TRUNCATE TABLE categories;');
        DB::statement('ALTER TABLE categories AUTO_INCREMENT = 1;');
        // Array of categories
        $categories = [
            'Electronics Devices',
            'Keys',
            'Water Bottles',
            'Wallets',
            'Student ID Cards',
            'Books',
            'Pencil Cases',
            'Documents',
            'Laptops',
            'Notebooks',
            'Umbrellas',
            'Glasses',
            'Clothing',
            'Headphones',
            'Jewelry',
            'Bicycles',
            'Sports Equipment',
            'Musical Instruments',
            'Art Supplies',
            'Backpacks',
            'Food Containers',
            'Accessories'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
