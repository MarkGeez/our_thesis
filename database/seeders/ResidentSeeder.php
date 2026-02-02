<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resident;
use Carbon\Carbon;

class ResidentSeeder extends Seeder
{
    public function run()
    {
        $baseResident = [
            'firstName' => 'bla',
            'middleName' => 'bla',
            'lastName' => 'bla',
            'contactNo' => '09216461025',
            'religion' => 'Irure velit voluptat',
            'birthday' => '2026-02-01',
            'emergencyContactNo' => '09216461025',
            'emergencyContactName' => 'dsadsada',
            'age' => 0,
            'sex' => 'male',
            'parent' => 'yes',
            'enrolled' => 'yes',
            'educationalAttainment' => 'Dolorem itaque disti',
            'headOfFamily' => 'yes',
            'EncodedBy' => 1,
            'image_path' => null
        ];

        // Create 50 residents starting with ID 5
        for ($i = 5; $i <= 54; $i++) {
            Resident::create(array_merge($baseResident, [
                'id' => $i,
                'user_id' => null, 
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now()->subDays(rand(0, 30)),
            ]));
        }
    }
}