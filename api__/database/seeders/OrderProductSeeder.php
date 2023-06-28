<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_products')->insert([
            'order_id' => 1,
            'product_id'=> 1,
            'total_quantity' => 1,
            'total_amount' => "330000",
         ]);

         DB::table('order_products')->insert([
            'order_id' => 1,
            'product_id'=> 2,
            'total_quantity' => 1,
            'total_amount' => "5688900",
         ]);
         DB::table('order_products')->insert([
            'order_id' => 1,
            'product_id'=> 3,
            'total_quantity' => 1,
            'total_amount' =>"34400",
         ]);

         DB::table('order_products')->insert([
            'order_id' => 2,
            'product_id'=> 4,
            'total_quantity' => 1,
            'total_amount' =>"12400",
         ]);
    }
}
