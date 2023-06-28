<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder {
    /**
    * Run the database seeds.
    *
    * @return void
    */

    public function run() {
        $regions = [
            [
                'name' => 'Arusha Region',
                'lng' => 36.6830,
                'lat' => -3.3869,
            ],
            [
                'name' => 'Dar es Salaam Region',
                'lng' => 39.2083,
                'lat' => -6.7924,
            ],
            [
                'name' => 'Dodoma Region',
                'lng' => 35.7372,
                'lat' => -6.1629,
            ],
            [
                'name' => 'Geita Region',
                'lng' => 32.1791,
                'lat' => -2.8744,
            ],
            [
                'name' => 'Iringa Region',
                'lng' => 35.6856,
                'lat' => -7.7675,
            ],
            [
                'name' => 'Kagera Region',
                'lng' => 31.0572,
                'lat' => -1.9852,
            ],
            [
                'name' => 'Katavi Region',
                'lng' => 31.1000,
                'lat' => -6.5333,
            ],
            [
                'name' => 'Kigoma Region',
                'lng' => 29.6167,
                'lat' => -4.8769,
            ],
            [
                'name' => 'Kilimanjaro Region',
                'lng' => 37.2995,
                'lat' => -3.0674,
            ],
            [
                'name' => 'Lindi Region',
                'lng' => 39.8811,
                'lat' => -9.8015,
            ],
            [
                'name' => 'Manyara Region',
                'lng' => 35.9770,
                'lat' => -4.8454,
            ],
            [
                'name' => 'Mara Region',
                'lng' => 34.1449,
                'lat' => -1.8644,
            ],
            [
                'name' => 'Mbeya Region',
                'lng' => 33.4608,
                'lat' => -8.8889,
            ],
            [
                'name' => 'Morogoro Region',
                'lng' => 37.6610,
                'lat' => -7.1736,
            ],
            [
                'name' => 'Mtwara Region',
                'lng' => 40.1792,
                'lat' => -10.2773,
            ],
            [
                'name' => 'Mwanza Region',
                'lng' => 32.9208,
                'lat' => -2.5149,
            ],
            [
                'name' => 'Njombe Region',
                'lng' => 34.7667,
                'lat' => -9.3344,
            ],
            [
                'name' => 'Pemba North Region',
                'lng' => 39.7468,
                'lat' => -5.0435,
            ],
            [
                'name' => 'Pemba South Region',
                'lng' => 39.6057,
                'lat' => -5.2519,
            ],
            [
                'name' => 'Pwani Region',
                'lng' => 38.9787,
                'lat' => -7.5290,
            ],
            [
                'name' => 'Rukwa Region',
                'lng' => 31.9500,
                'lat' => -7.9869,
            ],
            [
                'name' => 'Ruvuma Region',
                'lng' => 35.8167,
                'lat' => -10.6827,
            ],
            [
                'name' => 'Shinyanga Region',
                'lng' => 33.4833,
                'lat' => -3.6667,
            ],
            [
                'name' => 'Simiyu Region',
                'lng' => 34.6864,
                'lat' => -3.5167,
            ],
            [
                'name' => 'Singida Region',
                'lng' => 34.7417,
                'lat' => -5.6869,
            ],
            [
                'name' => 'Songwe Region',
                'lng' => 33.4083,
                'lat' => -9.1359,
            ],
            [
                'name' => 'Tabora Region',
                'lng' => 32.8072,
                'lat' => -4.4329,
            ],
            [
                'name' => 'Tanga Region',
                'lng' => 39.1022,
                'lat' => -5.0275,
            ],
            [
                'name' => 'Zanzibar Central/South Region',
                'lng' => 39.2888,
                'lat' => -6.1620,
            ],
            [
                'name' => 'Zanzibar North Region',
                'lng' => 39.2939,
                'lat' => -5.9804,
            ],
            [
                'name' => 'Zanzibar Urban/West Region',
                'lng' => 39.1888,
                'lat' => -6.1655,
            ],
        ];

        foreach ( $regions as $region ) {
            DB::table( 'regions' )->insert( [
                'name' => $region,
            ] );
        }
    }

}
