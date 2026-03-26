<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\Household;
use App\Models\Resident;
use App\Models\Street;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HouseholdSeeder extends Seeder
{
    public function run(): void
    {
        if (House::query()->count() === 0) {
            $street = Street::firstOrCreate([
                'street_name' => 'Seeder Street',
            ]);

            for ($i = 1; $i <= 20; $i++) {
                House::firstOrCreate(
                    [
                        'street_id' => $street->id,
                        'house_no' => 'S-' . str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                    ],
                    [
                        'property_type' => 'residential',
                    ]
                );
            }
        }

        $residents = Resident::query()->orderBy('id')->get();

        if ($residents->isEmpty()) {
            return;
        }

        $houses = House::query()->orderBy('id')->get()->values();
        $householdSize = 5;

        foreach ($residents->chunk($householdSize) as $chunkIndex => $residentChunk) {
            $house = $houses[$chunkIndex % $houses->count()];
            $household = Household::firstOrCreate([
                'house_id' => $house->id,
            ]);

            foreach ($residentChunk->values() as $residentIndex => $resident) {
                DB::table('household_resident')->updateOrInsert(
                    [
                        'household_id' => $household->id,
                        'resident_id' => $resident->id,
                    ],
                    [
                        'is_household_head' => $residentIndex === 0,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }
    }
}
