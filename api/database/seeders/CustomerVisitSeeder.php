<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerVisitSeeder extends Seeder {
    /**
    * Run the database seeds.
    */

    public function run(): void {
        DB::table( 'customer_visits' )->insert( [
            'time_spent' => '11 minutes',
            'customer_id'=>1,
            'user_id'=>1,
            'business_id'=>1,
            'created_at' => \Carbon\Carbon::now()
        ] );


        DB::table( 'customer_visits' )->insert( [
            'time_spent' => '8 minutes',
            'customer_id'=>2,
            'user_id'=>1,
            'business_id'=>1,
            'created_at' => \Carbon\Carbon::now()
        ] );


        DB::table( 'customer_visits' )->insert( [
            'time_spent' => '5 minutes',
            'customer_id'=>3,
            'user_id'=>1,
            'business_id'=>1,
            'created_at' => \Carbon\Carbon::now()
        ] );


        DB::table( 'customer_visits' )->insert( [
            'time_spent' => '11 minutes',
            'customer_id'=>1,
            'user_id'=>1,
            'business_id'=>1,
            'created_at' => \Carbon\Carbon::now()
        ] );

    }
}
