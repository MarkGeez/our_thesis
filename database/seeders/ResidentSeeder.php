<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resident;
use Carbon\Carbon;

class ResidentSeeder extends Seeder
{
    public function run(): void
    {
        $firstNames = [
            'Juan', 'Jose', 'Maria', 'Ana', 'Mark', 'Carlo', 'Ramon', 'Liza', 'Paolo', 'Jessa',
            'Ricardo', 'Elena', 'Miguel', 'Leah', 'Jomar', 'Rosalie', 'Nico', 'Aileen', 'Jerome', 'Clarisse',
            'Arvin', 'Kristine', 'Dennis', 'Catherine', 'Ralph', 'Joanna', 'Bryan', 'Angelica', 'Alvin', 'Sharmaine',
            'Noel', 'Maricel', 'Renato', 'Cherry', 'Emmanuel', 'Riza', 'Kenneth', 'Janine', 'Gilbert', 'Therese',
            'Victor', 'Mylene', 'Patrick', 'Vanessa', 'Ronald', 'Diane', 'Francis', 'Camille', 'Nelson', 'Bianca'
        ];

        $lastNames = [
            'Santos', 'Reyes', 'Cruz', 'Bautista', 'Garcia', 'Mendoza', 'Torres', 'Ramos', 'Flores', 'Gonzales',
            'Aquino', 'Diaz', 'Navarro', 'Castro', 'Villanueva', 'Morales', 'Fernandez', 'Herrera', 'Pascual', 'Salazar',
            'Domingo', 'Mercado', 'DelosReyes', 'Padilla', 'Soriano', 'Natividad', 'Estrella', 'Valdez', 'Ocampo', 'Panganiban',
            'Lazaro', 'Samson', 'Manalo', 'Rosales', 'Bonifacio', 'Aguilar', 'Sarmiento', 'Abad', 'David', 'Tiongson',
            'Magbanua', 'Marquez', 'Tolentino', 'Yap', 'Lopez', 'Cuevas', 'Balagtas', 'Andres', 'Macapagal', 'DeGuzman'
        ];

        $middleNames = [
            'DelaCruz', 'Velasco', 'Manansala', 'Alcantara', 'Pineda', 'Sandoval', 'Trinidad', 'Guinto', 'Peralta', 'Lim',
            'Caballero', 'Santiago', 'Benedicto', 'Matias', 'Arevalo', 'Corpuz', 'Ladrido', 'Chua', 'Talavera', 'Rivera',
            'Espiritu', 'Beltran', 'Dizon', 'Malonzo', 'Palma', 'Arce', 'Cabrera', 'Ferrer', 'Ponce', 'Maranan',
            'Solis', 'Tadeo', 'Llorente', 'Camacho', 'Barrios', 'Jamora', 'Lucero', 'Cortez', 'Ricarte', 'Magtibay'
        ];

        $religions = [
            'Roman Catholic',
            'Christian',
            'Iglesia ni Cristo',
            'Born Again'
        ];

        for ($i = 0; $i < 50; $i++) {
            $birthday = Carbon::createFromDate(1975 + ($i % 25), ($i % 12) + 1, ($i % 28) + 1);
            $middleName = $i < 10 ? '' : $middleNames[$i - 10];
            $contactNo = '09' . str_pad((string) (110000000 + $i), 9, '0', STR_PAD_LEFT);
            $emergencyContactNo = '09' . str_pad((string) (220000000 + $i), 9, '0', STR_PAD_LEFT);

            Resident::firstOrCreate([
                'contactNo' => $contactNo,
            ], [
                'firstName' => $firstNames[$i],
                'middleName' => $middleName,
                'lastName' => $lastNames[$i],
                'religion' => $religions[$i % count($religions)],
                'birthday' => $birthday->format('Y-m-d'),
                'emergencyContactNo' => $emergencyContactNo,
                'emergencyContactName' => 'Emergency Contact ' . ($i + 1),
                'age' => $birthday->age,
                'sex' => $i % 2 === 0 ? 'male' : 'female',
                'parent' => ['yes', 'no', 'single'][$i % 3],
                'enrolled' => $i % 3 === 0 ? 'yes' : 'no',
                'educationalAttainment' => $i % 2 === 0 ? 'High School Graduate' : 'College Undergraduate',
                'headOfFamily' => $i % 5 === 0 ? 'yes' : 'no',
                'type' => null,
                'EncodedBy' => 1,
                'user_id' => null,
                'image_path' => null,
            ]);
        }
    }
}