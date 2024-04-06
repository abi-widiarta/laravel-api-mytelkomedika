<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PatientSeeder::class,
            AdminSeeder::class,
            DoctorSeeder::class,
            ScheduleTimeSeeder::class,
            DoctorScheduleSeeder::class,
            ReservationSeeder::class,
            ReportSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
