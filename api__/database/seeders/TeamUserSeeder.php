<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('team_users')->insert([
            'team_id' => 3,
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('team_users')->insert([
            'team_id' => 2,
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('team_users')->insert([
            'team_id' => 2,
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('team_users')->insert([
            'team_id' => 1,
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]);

    }
}
