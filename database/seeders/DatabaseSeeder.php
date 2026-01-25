<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

         $street = DB::table('streets')->insertGetId([
            'street_name' => 'musa',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        DB::table('houses')->insert([
            ['street_id' => $street, 'house_no' => '1134', 'property_type' => "residential", 'created_at' => now(), 'updated_at' => now(), ]
        ]);
    }
}
        