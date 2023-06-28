<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businessTypes = [
            ['name' => 'Restaurant'],
            ['name' => 'Retail Store'],
            ['name' => 'Consulting Firm'],
            ['name' => 'Fitness Center'],
            ['name' => 'Software Company'],
        ];

        DB::table('business_types')->insert($businessTypes);
    }
}
