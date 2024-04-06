<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dokter 1

        $rand = [24, 20, 28, 19, 27, 23, 22, 29, 21, 25, 30, 26, 18, 20, 29, 27, 19, 23];

        for ($i=1; $i <= 18 ; $i++) { 
            for ($j = 1; $j <= $rand[$i - 1]; $j++) {
                Reservation::create([
                    'patient_id' => $j,
                    'doctor_id' => $i,
                    'date' => '2023-12-22',
                    'start_hour' => '07:00:00',
                    'end_hour' => '09:00:00',
                    'status' => 'completed',
                    'initial_complaint' => 'sakit kepala, pusing, meriang',
                    'queue_number' => $j,
                ]);
            }
        }
    }
}
