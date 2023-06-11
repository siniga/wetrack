<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder {
    /**
    * Run the database seeds.
    */

    public function run(): void {
        $users = [
            [
                'name' => 'John Doe',
                'phone' => '1234567890',
                'email' => 'john@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make( 'password' ),
                'role' => 'user',
                'remember_token' => Str::random( 10 ),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'phone' => '9876543210',
                'email' => 'jane@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make( 'password' ),
                'role' => 'user',
                'remember_token' => Str::random( 10 ),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table( 'users' )->insert( $users );
    }
}
