<?php

namespace Database\Seeders;

use App\Models\ScheduleTime;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScheduleTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScheduleTime::create([
            "start_hour" => "07:00:00",
            "end_hour" => "09:00:00",
        ]);
        ScheduleTime::create([
            "start_hour" => "10:00:00",
            "end_hour" => "12:00:00",
        ]);
        ScheduleTime::create([
            "start_hour" => "13:00:00",
            "end_hour" => "15:00:00",
        ]);
        ScheduleTime::create([
            "start_hour" => "16:00:00",
            "end_hour" => "18:00:00",
        ]);
        ScheduleTime::create([
            "start_hour" => "19:00:00",
            "end_hour" => "21:00:00",
        ]);
        
    }
}
