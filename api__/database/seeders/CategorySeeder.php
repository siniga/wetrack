<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'url' => 'electronics',
                'business_id' => 1,
            ],
            [
                'name' => 'Clothing',
                'url' => 'clothing',
                'business_id' => 1,
            ],
            [
                'name' => 'Home Appliances',
                'url' => 'home-appliances',
                'business_id' => 2,
            ],
            [
                'name' => 'Books',
                'url' => 'books',
                'business_id' => 2,
            ],
            [
                'name' => 'Sports Equipment',
                'url' => 'sports-equipment',
                'business_id' => 3,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
