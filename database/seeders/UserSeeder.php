<?php

namespace Database\Seeders;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ResidentSeeder::class);
        $this->call(HouseholdSeeder::class);

        $defaultUsers = [
            [
                'email' => 'johnstephenf30@gmail.com',
                'password' => Hash::make('admin123'),
                'firstName' => 'John',
                'middleName' => 'Stephen',
                'lastName' => 'F',
                'contactNumber' => '09123456789',
                'birthday' => '2000-01-01',
                'proofOfIdentity' => 'default-id.png',
                'role' => 'superadmin',
                'status' => 'approved',
                'profile_image' => 'default-profile.png',
                'registrationDate' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'email' => 'markgraelangee@gmail.com',
                'password' => Hash::make('admin123'),
                'firstName' => 'Mark',
                'middleName' => 'Graelan',
                'lastName' => 'Gee',
                'contactNumber' => '09987654321',
                'birthday' => '2000-01-01',
                'proofOfIdentity' => 'default-id.png',
                'role' => 'superadmin',
                'status' => 'approved',
                'profile_image' => 'default-profile.png',
                'registrationDate' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'email' => 'brgy249admin@gmail.com',
                'password' => Hash::make('Admin123'),
                'firstName' => 'Brgy249',
                'middleName' => '',
                'lastName' => 'Admin',
                'contactNumber' => '09111111111',
                'birthday' => '2000-01-01',
                'proofOfIdentity' => 'default-id.png',
                'role' => 'admin',
                'status' => 'approved',
                'profile_image' => 'default-profile.png',
                'registrationDate' => now(),
                'remember_token' => Str::random(10),
            ],
        ];

        foreach ($defaultUsers as $defaultUser) {
            User::updateOrCreate(
                ['email' => $defaultUser['email']],
                $defaultUser
            );
        }

        $residentsToBind = Resident::query()
            ->orderBy('id')
            ->limit(30)
            ->get();

        foreach ($residentsToBind as $resident) {
            $email = sprintf(
                'resident%02d.%s@example.com',
                $resident->id,
                strtolower($resident->lastName)
            );

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'password' => Hash::make('resident123'),
                    'firstName' => $resident->firstName,
                    'middleName' => $resident->middleName,
                    'lastName' => $resident->lastName,
                    'contactNumber' => $resident->contactNo,
                    'birthday' => $resident->birthday,
                    'proofOfIdentity' => 'default-id.png',
                    'role' => 'resident',
                    'status' => 'approved',
                    'profile_image' => 'default-profile.png',
                    'registrationDate' => now(),
                    'remember_token' => Str::random(10),
                ]
            );

            $resident->update(['user_id' => $user->id]);
        }
    }
}