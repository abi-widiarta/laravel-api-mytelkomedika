<?php

namespace Database\Seeders;

use App\Models\DoctorSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $doctorSchedulesData =  [

            // POLI UMUM

            // Doctor 1
            [
                "doctor_id" => 1,
                "schedule_time_id" => 1,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 1,
                "schedule_time_id" => 2,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 1,
                "schedule_time_id" => 1,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 1,
                "schedule_time_id" => 2,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 1,
                "schedule_time_id" => 1,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 1,
                "schedule_time_id" => 2,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            // POLI UMUM

            // Doctor 2
            [
                "doctor_id" => 2,
                "schedule_time_id" => 4,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 2,
                "schedule_time_id" => 5,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 2,
                "schedule_time_id" => 4,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 2,
                "schedule_time_id" => 5,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 2,
                "schedule_time_id" => 4,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            
            [
                "doctor_id" => 2,
                "schedule_time_id" => 5,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            // POLI UMUM

            // Doctor 3
            [
                "doctor_id" => 3,
                "schedule_time_id" => 3,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 3,
                "schedule_time_id" => 3,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 3,
                "schedule_time_id" => 3,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            // POLI UMUM

            // Doctor 4
            [
                "doctor_id" => 4,
                "schedule_time_id" => 1,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 4,
                "schedule_time_id" => 2,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 4,
                "schedule_time_id" => 1,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
      
            [
                "doctor_id" => 4,
                "schedule_time_id" => 2,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            // POLI UMUM

            // Doctor 5
            [
                "doctor_id" => 5,
                "schedule_time_id" => 4,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
      
            [
                "doctor_id" => 5,
                "schedule_time_id" => 5,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 5,
                "schedule_time_id" => 4,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
      
            [
                "doctor_id" => 5,
                "schedule_time_id" => 5,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            // POLI UMUM

            // Doctor 6
            [
                "doctor_id" => 6,
                "schedule_time_id" => 3,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 6,
                "schedule_time_id" => 3,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],

            // POLI MATA

            // Doctor 1
            [
                "doctor_id" => 7,
                "schedule_time_id" => 1,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 7,
                "schedule_time_id" => 2,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 7,
                "schedule_time_id" => 1,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 7,
                "schedule_time_id" => 2,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 7,
                "schedule_time_id" => 1,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 7,
                "schedule_time_id" => 2,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],

            // POLI MATA

            // Doctor 2
            [
                "doctor_id" => 8,
                "schedule_time_id" => 4,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 8,
                "schedule_time_id" => 5,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 8,
                "schedule_time_id" => 4,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 8,
                "schedule_time_id" => 5,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 8,
                "schedule_time_id" => 4,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            
            [
                "doctor_id" => 8,
                "schedule_time_id" => 5,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],

            // POLI MATA

            // Doctor 3
            [
                "doctor_id" => 9,
                "schedule_time_id" => 3,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 9,
                "schedule_time_id" => 3,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 9,
                "schedule_time_id" => 3,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],

            // POLI MATA

            // Doctor 4
            [
                "doctor_id" => 10,
                "schedule_time_id" => 1,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 10,
                "schedule_time_id" => 2,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 10,
                "schedule_time_id" => 1,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
      
            [
                "doctor_id" => 10,
                "schedule_time_id" => 2,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            // POLI MATA

            // Doctor 5
            [
                "doctor_id" => 11,
                "schedule_time_id" => 4,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
      
            [
                "doctor_id" => 11,
                "schedule_time_id" => 5,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 11,
                "schedule_time_id" => 4,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
      
            [
                "doctor_id" => 11,
                "schedule_time_id" => 5,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            // POLI MATA

            // Doctor 6
            [
                "doctor_id" => 12,
                "schedule_time_id" => 3,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 12,
                "schedule_time_id" => 3,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],

            // POLI GIGI

            // Doctor 1
            [
                "doctor_id" => 13,
                "schedule_time_id" => 1,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 13,
                "schedule_time_id" => 2,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 13,
                "schedule_time_id" => 1,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 13,
                "schedule_time_id" => 2,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 13,
                "schedule_time_id" => 1,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 13,
                "schedule_time_id" => 2,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],

            // POLI GIGI

            // Doctor 2
            [
                "doctor_id" => 14,
                "schedule_time_id" => 4,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 14,
                "schedule_time_id" => 5,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 14,
                "schedule_time_id" => 4,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 14,
                "schedule_time_id" => 5,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 14,
                "schedule_time_id" => 4,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            
            [
                "doctor_id" => 14,
                "schedule_time_id" => 5,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],

            // POLI GIGI

            // Doctor 3
            [
                "doctor_id" => 15,
                "schedule_time_id" => 3,
                "day" => "senin",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 15,
                "schedule_time_id" => 3,
                "day" => "rabu",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 15,
                "schedule_time_id" => 3,
                "day" => "jumat",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],

            // POLI GIGI

            // Doctor 4
            [
                "doctor_id" => 16,
                "schedule_time_id" => 1,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 16,
                "schedule_time_id" => 2,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 16,
                "schedule_time_id" => 1,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
      
            [
                "doctor_id" => 16,
                "schedule_time_id" => 2,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            // POLI GIGI

            // Doctor 5
            [
                "doctor_id" => 17,
                "schedule_time_id" => 4,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
      
            [
                "doctor_id" => 17,
                "schedule_time_id" => 5,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            [
                "doctor_id" => 17,
                "schedule_time_id" => 4,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
      
            [
                "doctor_id" => 17,
                "schedule_time_id" => 5,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
    
            // POLI GIGI

            // Doctor 6
            [
                "doctor_id" => 18,
                "schedule_time_id" => 3,
                "day" => "selasa",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],
            [
                "doctor_id" => 18,
                "schedule_time_id" => 3,
                "day" => "kamis",
                "max_patient" => 30,
                "end_date" => "2024-07-08",
            ],

        ];

        foreach ($doctorSchedulesData as $data) {
            DoctorSchedule::create([
                "doctor_id" => $data['doctor_id'],
                "schedule_time_id" => $data['schedule_time_id'],
                "day" => $data['day'],
                "max_patient" => $data['max_patient'],
                "end_date" => $data['end_date'],
            ]);
        }
        // Doctor GIGI
    }
}
