<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder {
    /**
    * Run the database seeds.
    */

    public function run(): void {

        DB::table( 'customers' )->insert( [
            'name' => 'Khalid Musa',
            'phone'=> '0728334928',
            'device_time'=>\Carbon\Carbon::now()->format( 'Y-m-d H:i:s' ),
            'created_date'=>\Carbon\Carbon::now()->format( 'Y-m-d' ),
            'lat'=>'-6.790555',
            'lng'=>'39.247950',
            'location' => 'Knondoni',
            'user_id' => 2,
            'customer_type_id' => 1,
            'district_id'=> 1,
            'business_id'=> 1,
            'user_input_address' =>'Mikocheni',
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'customers' )->insert( [
            'name' => 'Juma Mohamed',
            'phone'=> '072344448',
            'device_time'=>\Carbon\Carbon::now()->format( 'Y-m-d H:i:s' ),
            'created_date'=>\Carbon\Carbon::now()->format( 'Y-m-d' ),
            'lat'=>'-6.803169',
            'lng'=>'39.278849',
            'location' => 'Knondoni',
            'user_id' => 2,
            'customer_type_id' => 1,
            'district_id'=> 3,
            'business_id'=> 1,
            'user_input_address' =>'Mikocheni',
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'customers' )->insert( [
            'name' => 'Salim mugaza',
            'phone'=> '0728334228',
            'device_time'=>\Carbon\Carbon::now()->format( 'Y-m-d H:i:s' ),
            'created_date'=>\Carbon\Carbon::now()->format( 'Y-m-d' ),
            'lat'=>'-6.838622',
            'lng'=>'39.312838',
            'location' => 'Knondoni',
            'user_id' => 2,
            'customer_type_id' => 3,
            'district_id'=> 3,
            'business_id'=> 1,
            'user_input_address' =>'Mikocheni',
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'customers' )->insert( [
            'name' => 'Misano chisano',
            'phone'=> '0728334928',
            'device_time'=>\Carbon\Carbon::now()->format( 'Y-m-d H:i:s' ),
            'created_date'=>\Carbon\Carbon::now()->format( 'Y-m-d' ),
            'lat'=>'-6.804533',
            'lng'=>'39.219454',
            'location' => 'Knondoni',
            'user_id' => 2,
            'customer_type_id' => 2,
            'district_id'=> 1,
            'business_id'=> 1,
            'user_input_address' =>'Mikocheni',
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'customers' )->insert( [
            'name' => 'Patric kaembe',
            'phone'=> '0728334928',
            'device_time'=>\Carbon\Carbon::now()->format( 'Y-m-d H:i:s' ),
            'created_date'=>\Carbon\Carbon::now()->format( 'Y-m-d' ),
            'lat'=>'-6.766009',
            'lng'=>'39.239710',
            'location' => 'Knondoni',
            'user_id' => 2,
            'customer_type_id' => 1,
            'district_id'=> 2,
            'business_id'=> 1,
            'user_input_address' =>'Mikocheni',
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'customers' )->insert( [
            'name' => 'Maluma Maluma',
            'phone'=> '0728331123',
            'device_time'=>\Carbon\Carbon::now()->format( 'Y-m-d H:i:s' ),
            'created_date'=>\Carbon\Carbon::now()->format( 'Y-m-d' ),
            'lat'=>'-6.820325',
            'lng'=>'39.168612',
            'location' => 'Knondoni',
            'user_id' => 1,
            'customer_type_id' => 3,
            'district_id'=> 2,
            'business_id'=> 1,
            'user_input_address' =>'Mikocheni',
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'customers' )->insert( [
            'name' => 'Jerlard juma',
            'phone'=> '07283312223',
            'device_time'=>\Carbon\Carbon::now()->format( 'Y-m-d H:i:s' ),
            'created_date'=>\Carbon\Carbon::now()->format( 'Y-m-d' ),
            'lat'=>'-6.751801',
            'lng'=>'39.175822',
            'location' => 'Knondoni',
            'user_id' => 2,
            'customer_type_id' => 4,
            'district_id'=> 1,
            'business_id'=> 1,
            'user_input_address' =>'Mikocheni',
            'created_at' => \Carbon\Carbon::now()
        ] );

        DB::table( 'customers' )->insert( [
            'name' => 'Kim salima',
            'phone'=> '072833111123',
            'device_time'=>\Carbon\Carbon::now()->format( 'Y-m-d H:i:s' ),
            'created_date'=>\Carbon\Carbon::now()->format( 'Y-m-d' ),
            'lat'=>'-6.798167',
            'lng'=>'39.247576',
            'location' => 'Knondoni',
            'user_id' => 2,
            'customer_type_id' => 4,
            'district_id'=> 1,
            'business_id'=> 1,
            'user_input_address' =>'Mikocheni',
            'created_at' => \Carbon\Carbon::now()
        ] );
    }
}
