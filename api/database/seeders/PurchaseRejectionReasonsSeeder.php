<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseRejectionReasonsSeeder extends Seeder {
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run() {
        //
        DB::table( 'purchase_rejection_reasons' )->insert( [
            'en'=>"No money",
            'sw' => "Hana pesa",
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'purchase_rejection_reasons' )->insert( [
            'en'=>"Already have the product",
            'sw' => "Tayari ameshanunua bidhaa",
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'purchase_rejection_reasons' )->insert( [
            'en'=>"Not interested",
            'sw' => "Hataki kununua bidhaa zetu",
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'purchase_rejection_reasons' )->insert( [
            'en'=>"Dont know the product",
            'sw' => "Hajui bidhaa zetu",
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'purchase_rejection_reasons' )->insert( [
            'en'=>"His customers dont like the product",
            'sw' => "Wateja wake hawapendi bidhaa zetu",
            'created_at' => \Carbon\Carbon::now()
        ] );
        
        DB::table( 'purchase_rejection_reasons' )->insert( [
            'en'=>"His customers cant afford the product",
            'sw' => "Wateja wake hawapendi bidhaa zetu",
            'created_at' => \Carbon\Carbon::now()
        ] );
        
        DB::table( 'purchase_rejection_reasons' )->insert( [
            'en'=>"His customers dont like the product",
            'sw' => "Wateja wake hawana uwezo kununua",
            'created_at' => \Carbon\Carbon::now()
        ] );
    }
}
