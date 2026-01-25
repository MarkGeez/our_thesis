<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Houses;

class StreetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $street = DB::table('streets')->insertGetId([
            'street_name' => 'musa',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        DB::table('houses')->insertInto([
            ['street_id' => $street, 'house_no' => '1134', 'property_type' => "residential", 'created_at' => now(), 'updated_at' => now(), ]
        ]);

        
    }
}
