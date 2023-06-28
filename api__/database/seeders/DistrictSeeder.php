<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder {
    /**
    * Run the database seeds.
    *
    * @return void
    */

    public function run() {
        $districts = [
            // Arusha Region
            [
                'name' => 'Meru',
                'region_id' => 1,
            ],
            [
                'name' => 'Arusha City',
                'region_id' => 1,
            ],
            [
                'name' => 'Arusha',
                'region_id' => 1,
            ],
            [
                'name' => 'Karatu',
                'region_id' => 1,
            ],
            [
                'name' => 'Longido',
                'region_id' => 1,
            ],
            [
                'name' => 'Monduli',
                'region_id' => 1,
            ],
            [
                'name' => 'Ngorongoro',
                'region_id' => 1,
            ],
            // Dar es Salaam Region
            [
                'name' => 'Kinondoni',
                'region_id' => 2,
            ],
            [
                'name' => 'Ilala',
                'region_id' => 2,
            ],
            [
                'name' => 'Temeke',
                'region_id' => 2,
            ],
            [
                'name' => 'Kigamboni',
                'region_id' => 2,
            ],
            [
                'name' => 'Ubungo',
                'region_id' => 2,
            ],
            // Dodoma Region
            [
                'name' => 'Bahi',
                'region_id' => 3,
            ],
            [
                'name' => 'Chamwino',
                'region_id' => 3,
            ],
            [
                'name' => 'Chemba',
                'region_id' => 3,
            ],
            [
                'name' => 'Dodoma',
                'region_id' => 3,
            ],
            [
                'name' => 'Kondoa',
                'region_id' => 3,
            ],
            [
                'name' => 'Kongwa',
                'region_id' => 3,
            ],
            [
                'name' => 'Mpwapwa',
                'region_id' => 3,
            ],
            // Geita Region
            [
                'name' => 'Bukombe',
                'region_id' => 4,
            ],
            [
                'name' => 'Chato',
                'region_id' => 4,
            ],
            [
                'name' => 'Geita Town',
                'region_id' => 4,
            ],
            [
                'name' => 'Mbogwe',
                'region_id' => 4,
            ],
            [
                'name' => 'Nyang’hwale',
                'region_id' => 4,
            ],
            // Iringa Region
            [
                'name' => 'Iringa District Council',
                'region_id' => 5,
            ],
            [
                'name' => 'Iringa Municipal Council',
                'region_id' => 5,
            ],
            [
                'name' => 'Kilolo',
                'region_id' => 5,
            ],
            [
                'name' => 'Mafinga Town',
                'region_id' => 5,
            ],
            [
                'name' => 'Mufindi',
                'region_id' => 5,
            ],
            // Kagera Region
            [
                'name' => 'Biharamulo',
                'region_id' => 6,
            ],
            [
                'name' => 'Bukoba District Council',
                'region_id' => 6,
            ],
            [
                'name' => 'Bukoba Municipal Council',
                'region_id' => 6,
            ],
            [
                'name' => 'Karagwe',
                'region_id' => 6,
            ],
            [
                'name' => 'Kyerwa',
                'region_id' => 6,
            ],
            [
                'name' => 'Missenyi',
                'region_id' => 6,
            ],
            [
                'name' => 'Muleba',
                'region_id' => 6,
            ],
            [
                'name' => 'Ngara',
                'region_id' => 6,
            ],
            // Katavi Region
            [
                'name' => 'Mlele',
                'region_id' => 7,
            ],
            [
                'name' => 'Mpanda District Council',
                'region_id' => 7,
            ],
            [
                'name' => 'Mpanda Town Council',
                'region_id' => 7,
            ],
            // Kigoma Region
            [
                'name' => 'Buhigwe',
                'region_id' => 8,
            ],
            [
                'name' => 'Kakonko',
                'region_id' => 8,
            ],
            [
                'name' => 'Kasulu District Council',
                'region_id' => 8,
            ],
            [
                'name' => 'Kasulu Town Council',
                'region_id' => 8,
            ],
            [
                'name' => 'Kibondo',
                'region_id' => 8,
            ],
            [
                'name' => 'Kigoma District Council',
                'region_id' => 8,
            ],
            [
                'name' => 'Kigoma-Ujiji Municipal Council',
                'region_id' => 8,
            ],
            [
                'name' => 'Uvinza',
                'region_id' => 8,
            ],
            // Kilimanjaro Region
            [
                'name' => 'Hai',
                'region_id' => 9,
            ],
            [
                'name' => 'Moshi District Council',
                'region_id' => 9,
            ],
            [
                'name' => 'Moshi Municipal Council',
                'region_id' => 9,
            ],
            [
                'name' => 'Mwanga',
                'region_id' => 9,
            ],
            [
                'name' => 'Rombo',
                'region_id' => 9,
            ],
            [
                'name' => 'Same',
                'region_id' => 9,
            ],
            [
                'name' => 'Siha',
                'region_id' => 9,
            ],
            // Lindi Region
            [
                'name' => 'Kilwa',
                'region_id' => 10,
            ],
            [
                'name' => 'Lindi District Council',
                'region_id' => 10,
            ],
            [
                'name' => 'Lindi Municipal Council',
                'region_id' => 10,
            ],
            [
                'name' => 'Liwale',
                'region_id' => 10,
            ],
            [
                'name' => 'Nachingwea',
                'region_id' => 10,
            ],
            [
                'name' => 'Ruangwa',
                'region_id' => 10,
            ],
            // Manyara Region
            [
                'name' => 'Babati Town Council',
                'region_id' => 11,
            ],
            [
                'name' => 'Babati District Council',
                'region_id' => 11,
            ],
            [
                'name' => 'Hanang',
                'region_id' => 11,
            ],
            [
                'name' => 'Mbulu',
                'region_id' => 11,
            ],
            [
                'name' => 'Simanjiro',
                'region_id' => 11,
            ],
            // Mara Region
            [
                'name' => 'Bunda',
                'region_id' => 12,
            ],
            [
                'name' => 'Butiama',
                'region_id' => 12,
            ],
            [
                'name' => 'Musoma District Council',
                'region_id' => 12,
            ],
            [
                'name' => 'Musoma Municipal Council',
                'region_id' => 12,
            ],
            [
                'name' => 'Rorya',
                'region_id' => 12,
            ],
            [
                'name' => 'Serengeti',
                'region_id' => 12,
            ],
            [
                'name' => 'Tarime',
                'region_id' => 12,
            ],
            // Mbeya Region
            [
                'name' => 'Busokelo',
                'region_id' => 13,
            ],
            [
                'name' => 'Chunya',
                'region_id' => 13,
            ],
            [
                'name' => 'Kyela',
                'region_id' => 13,
            ],
            [
                'name' => 'Mbarali',
                'region_id' => 13,
            ],
            [
                'name' => 'Mbeya City Council',
                'region_id' => 13,
            ],
            [
                'name' => 'Mbeya District Council',
                'region_id' => 13,
            ],
            [
                'name' => 'Rungwe',
                'region_id' => 13,
            ],
            // Morogoro Region
            [
                'name' => 'Gairo',
                'region_id' => 14,
            ],
            [
                'name' => 'Kilombero',
                'region_id' => 14,
            ],
            [
                'name' => 'Kilosa',
                'region_id' => 14,
            ],
            [
                'name' => 'Morogoro District Council',
                'region_id' => 14,
            ],
            [
                'name' => 'Morogoro Municipal Council',
                'region_id' => 14,
            ],
            [
                'name' => 'Mvomero',
                'region_id' => 14,
            ],
            [
                'name' => 'Ulanga',
                'region_id' => 14,
            ],
            [
                'name' => 'Malinyi',
                'region_id' => 14,
            ],
            [
                'name' => 'Ifakara',
                'region_id' => 14,
            ],
            // Mtwara Region
            [
                'name' => 'Masasi District Council',
                'region_id' => 15,
            ],
            [
                'name' => 'Masasi Town Council',
                'region_id' => 15,
            ],
            [
                'name' => 'Mtwara District Council',
                'region_id' => 15,
            ],
            [
                'name' => 'Mtwara Municipal Council',
                'region_id' => 15,
            ],
            [
                'name' => 'Nanyumbu',
                'region_id' => 15,
            ],
            [
                'name' => 'Newala',
                'region_id' => 15,
            ],
            [
                'name' => 'Tandahimba',
                'region_id' => 15,
            ],
            // Mwanza Region
            [
                'name' => 'Ilemela Municipal Council',
                'region_id' => 16,
            ],
            [
                'name' => 'Kwimba',
                'region_id' => 16,
            ],
            [
                'name' => 'Magu',
                'region_id' => 16,
            ],
            [
                'name' => 'Misungwi',
                'region_id' => 16,
            ],
            [
                'name' => 'Nyamagana Municipal Council',
                'region_id' => 16,
            ],
            [
                'name' => 'Sengerema',
                'region_id' => 16,
            ],
            [
                'name' => 'Ukerewe',
                'region_id' => 16,
            ],
            // Njombe Region
            [
                'name' => 'Ludewa',
                'region_id' => 17,
            ],
            [
                'name' => 'Makambako Town Council',
                'region_id' => 17,
            ],
            [
                'name' => 'Makete',
                'region_id' => 17,
            ],
            [
                'name' => 'Njombe District Council',
                'region_id' => 17,
            ],
            [
                'name' => 'Njombe Town Council',
                'region_id' => 17,
            ],
            [
                'name' => 'Wanging’ombe',
                'region_id' => 17,
            ],
            // Pemba North Region
            [
                'name' => 'Micheweni',
                'region_id' => 18,
            ],
            [
                'name' => 'Wete',
                'region_id' => 18,
            ],
            // Pemba South Region
            [
                'name' => 'Chake Chake',
                'region_id' => 19,
            ],
            [
                'name' => 'Mkoani',
                'region_id' => 19,
            ],
            // Pwani Region
            [
                'name' => 'Bagamoyo District Council',
                'region_id' => 20,
            ],
            [
                'name' => 'Bagamoyo Town Council',
                'region_id' => 20,
            ],
            [
                'name' => 'Kibaha District Council',
                'region_id' => 20,
            ],
            [
                'name' => 'Kibaha Town Council',
                'region_id' => 20,
            ],
            [
                'name' => 'Kisarawe',
                'region_id' => 20,
            ],
            [
                'name' => 'Mafia',
                'region_id' => 20,
            ],
            [
                'name' => 'Mkuranga',
                'region_id' => 20,
            ],
            [
                'name' => 'Rufiji',
                'region_id' => 20,
            ],
            // Rukwa Region
            [
                'name' => 'Kalambo',
                'region_id' => 21,
            ],
            [
                'name' => 'Nkasi',
                'region_id' => 21,
            ],
            [
                'name' => 'Sumbawanga District Council',
                'region_id' => 21,
            ],
            [
                'name' => 'Sumbawanga Municipal Council',
                'region_id' => 21,
            ],
            // Ruvuma Region
            [
                'name' => 'Mbinga',
                'region_id' => 22,
            ],
            [
                'name' => 'Namtumbo',
                'region_id' => 22,
            ],
            [
                'name' => 'Nyasa',
                'region_id' => 22,
            ],
            [
                'name' => 'Songea District Council',
                'region_id' => 22,
            ],
            [
                'name' => 'Songea Municipal Council',
                'region_id' => 22,
            ],
            [
                'name' => 'Tunduru',
                'region_id' => 22,
            ],
            // Shinyanga Region
            [
                'name' => 'Kahama District Council',
                'region_id' => 23,
            ],
            [
                'name' => 'Kahama Town Council',
                'region_id' => 23,
            ],
            [
                'name' => 'Kishapu',
                'region_id' => 23,
            ],
            [
                'name' => 'Shinyanga District Council',
                'region_id' => 23,
            ],
            [
                'name' => 'Shinyanga Municipal Council',
                'region_id' => 23,
            ],
            [
                'name' => 'Ushetu',
                'region_id' => 23,
            ],
            // Simiyu Region
            [
                'name' => 'Bariadi District Council',
                'region_id' => 24,
            ],
            [
                'name' => 'Bariadi Town Council',
                'region_id' => 24,
            ],
            [
                'name' => 'Itilima',
                'region_id' => 24,
            ],
            [
                'name' => 'Maswa',
                'region_id' => 24,
            ],
            [
                'name' => 'Meatu',
                'region_id' => 24,
            ],
            // Singida Region
            [
                'name' => 'Iramba',
                'region_id' => 25,
            ],
            [
                'name' => 'Manyoni District Council',
                'region_id' => 25,
            ],
            [
                'name' => 'Manyoni Town Council',
                'region_id' => 25,
            ],
            [
                'name' => 'Singida District Council',
                'region_id' => 25,
            ],
            [
                'name' => 'Singida Municipal Council',
                'region_id' => 25,
            ],
            // Songwe Region
            [
                'name' => 'Ileje',
                'region_id' => 26,
            ],
            [
                'name' => 'Mbozi',
                'region_id' => 26,
            ],
            [
                'name' => 'Momba',
                'region_id' => 26,
            ],
            [
                'name' => 'Songwe',
                'region_id' => 26,
            ],
            // Tabora Region
            [
                'name' => 'Igunga',
                'region_id' => 27,
            ],
            [
                'name' => 'Kaliua',
                'region_id' => 27,
            ],
            [
                'name' => 'Nzega District Council',
                'region_id' => 27,
            ],
            [
                'name' => 'Nzega Town Council',
                'region_id' => 27,
            ],
            [
                'name' => 'Sikonge',
                'region_id' => 27,
            ],
            [
                'name' => 'Tabora Municipal Council',
                'region_id' => 27,
            ],
            [
                'name' => 'Urambo',
                'region_id' => 27,
            ],
            // Tanga Region
            [
                'name' => 'Handeni District Council',
                'region_id' => 28,
            ],
            [
                'name' => 'Handeni Town Council',
                'region_id' => 28,
            ],
            [
                'name' => 'Kilindi',
                'region_id' => 28,
            ],
            [
                'name' => 'Korogwe District Council',
                'region_id' => 28,
            ],
            [
                'name' => 'Korogwe Town Council',
                'region_id' => 28,
            ],
            [
                'name' => 'Lushoto District Council',
                'region_id' => 28,
            ],
            [
                'name' => 'Lushoto Town Council',
                'region_id' => 28,
            ],
            [
                'name' => 'Muheza',
                'region_id' => 28,
            ],
            [
                'name' => 'Pangani District Council',
                'region_id' => 28,
            ],
            [
                'name' => 'Pangani Town Council',
                'region_id' => 28,
            ],
            [
                'name' => 'Tanga City Council',
                'region_id' => 28,
            ],
            // Zanzibar Central/South Region
            [
                'name' => 'Kati',
                'region_id' => 29,
            ],
            [
                'name' => 'Kusini',
                'region_id' => 29,
            ],
            // Zanzibar North Region
            [
                'name' => 'Kaskazini A',
                'region_id' => 30,
            ],
            [
                'name' => 'Kaskazini B',
                'region_id' => 30,
            ],
            // Zanzibar Urban/West Region
            [
                'name' => 'Mjini Magharibi',
                'region_id' => 31,
            ],
            [
                'name' => 'Magharibi A',
                'region_id' => 31,
            ],
            [
                'name' => 'Magharibi B',
                'region_id' => 31,
            ],
        ];

        foreach ( $districts as $district ) {
            DB::table( 'districts' )->insert( [
                'name' => $district
            ] );
        }
    }
}
