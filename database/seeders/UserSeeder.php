<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
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
                'created_at' => now(),
                'updated_at' => now(),
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
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}