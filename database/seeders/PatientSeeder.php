<?php

namespace Database\Seeders;
use Faker\Factory as Faker;

use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $faker = Faker::create('id_ID');

        $patientsData = [];

        Patient::create( [
            'username' => 'abiwidi',
            'name' => 'Abi Widiarta',
            'email' => 'abiwidiarta@student.telkomuniversity.ac.id',
            'password' => bcrypt('AAAAa1!'),
            'gender' => 'L',
            'address' => "Jl. Telekomunikasi",
            "phone" => "082237910255",
            'student_id' => '1301213196',
            'birthdate' => "2003-01-01",
            'email_verified_at' => '2023-12-11 02:51:12'
        ]);

        for ($i = 1; $i <= 29; $i++) {
            $rawUsername = $faker->unique()->userName;
            $truncatedUsername = substr($rawUsername, 0, 15);
            $patientsData[] = [
                'username' =>  $truncatedUsername,
                'name' => $faker->name,
                'email' => $truncatedUsername . '@student.telkomuniversity.ac.id',
                'password' => bcrypt('AAAAa1!'),
                'gender' => ['L', 'P'][array_rand(['L', 'P'])],
                'address' => "Jl. Telekomunikasi",
                "phone" => "082237910255",
                'birthdate' => $faker->date($format = 'Y-m-d', $max = '2003-01-01'),
                'student_id' => '130121' . $faker->randomNumber(4),
                'email_verified_at' => $faker->dateTimeThisMonth('now', 'Asia/Jakarta'),
            ];
        }
        
        // Simpan data dummy ke database atau lakukan sesuai kebutuhan Anda
        foreach ($patientsData as $data) {
            Patient::create($data);
        }
    }
}
