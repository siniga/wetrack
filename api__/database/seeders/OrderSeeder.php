<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            'device_time' => '2021-05-26 13:26:18',
            'order_no' => 'slxj2v08',
            'status' => 2,
            'lng'=> '39.1774773',
            'lat'=> '-6.7871327',
            'user_id'=> 2,
            'location' => '',
            'customer_id'=> 1,
            'business_id'=>1,
            'created_at' => \Carbon\Carbon::now()
        ]);


        DB::table('orders')->insert([
            'device_time' => '2021-05-26 13:44:03',
            'order_no' => 'bx8ljb4a',
            'status' => 2,
            'lng'=> '39.196093',
            'lat'=> '-6.8452534',
            'user_id'=> 2,
            'location' => '',
            'customer_id'=> 1,
            'business_id'=>1,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('orders')->insert([
            'device_time' => '2021-05-26 14:02:18',
            'order_no' => 'fjkhagv0',
            'status' => 2,
            'lng'=> '39.1923182',
            'lat'=> '-6.8446975',
            'user_id'=> 1,
            'location' => '',
            'customer_id'=> 1,
            'business_id'=>1,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('orders')->insert([
            'device_time' => '2021-05-26 14:04:14t',
            'order_no' => 'slxj2v08',
            'status' => 2,
            'lng'=> '39.2039364',
            'lat'=> '-6.8032061',
            'user_id'=> 2,
            'location' => '',
            'customer_id'=> 1,
            'business_id'=>1,
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
