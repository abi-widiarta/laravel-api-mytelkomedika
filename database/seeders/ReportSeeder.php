<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   

        $rand = [24, 20, 28, 19, 27, 23, 22, 29, 21, 25, 30, 26, 18, 20, 29, 27, 19, 23];
        $sum = array_sum($rand);


        for ($i = 1; $i <= $sum; $i++) {
            Report::create([
                'reservation_id' => $i,
                'weight' => 72,
                'height' => 170,
                'temperature' => 38,
                'initial_complaint' => 'sakit kepala, pusing, meriang',
                'diagnosis' => 'demam, migrain',
                'recommendations' => 'kurangi gorengan, istirahat cukup, banyak minum air',
                'medications' => "paracetamol - 3x sehari\nvitamin - 2x sehari",
                'sick_note' => 1,
            ]);
        }

        for ($i = 1; $i <= $sum; $i++) {
            Payment::create([
                'reservation_id' => $i,
                'amount' => '0',
                'status' => 0
            ]);
        }
    }
}
