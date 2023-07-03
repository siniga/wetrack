<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RegionSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(BusinessTypeSeeder::class);
        $this->call(BusinessSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TeamUserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CustomerTypeSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(OrderProductSeeder::class);
        $this->call(PurchaseRejectionReasonsSeeder::class);
        $this->call(CustomerVisitSeeder::class);
    }
}
