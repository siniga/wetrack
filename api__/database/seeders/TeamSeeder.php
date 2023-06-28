<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teams')->insert([
            'name' => "Fresh-Daresalaam",
            'business_id'=>1,
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'name' => "TCC-Daresalaam",
            'business_id'=>1,
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'name' => "TBL-Daressalaam",
            'business_id'=>1,
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('teams')->insert([
            'name' => "Vodacom-Daresalaam",
            'business_id'=>1,
            'region_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
