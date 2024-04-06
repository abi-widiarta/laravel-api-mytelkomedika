<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorControllerTest extends TestCase
{   
    use RefreshDatabase;
    public function test_doctor_can_show_queues()
    {   
        // pembuatan data dokter untuk tes
        $doctor = Doctor::create([
            "name" => "Dr. Budi Santoso",
            "email"=> "budi@gmail.com",
            "username" => "budi_santoso",
            "password" => bcrypt("AAAAa1!"),
            "specialization" => "umum",
            "status" => "1",
            "registration_number" => "123126",
            "phone" => "081237010266",
            "gender" => "L",
            "birthdate" => "1985-05-15",
            "address" => "Jl. Cipto Mangunkusumo",
            "image" => "/uploads/img/budi_santoso.png",
        ]);

        // set middleware yang login ke website adalah dokter
        Auth::guard('doctor')->login($doctor);

        // mendapatkan antrian pemeriksaan
        $response = $this->get('/dokter/antrian-pemeriksaan');

        // mengecek apakah antrian pemeriksaan ditampilkan
        $response->assertStatus(200);
    }

    public function test_doctor_can_show_reviews()
    {   
        // pembuatan data dokter untuk tes
        $doctor = Doctor::create([
            "name" => "Dr. Budi Santoso",
            "email"=> "budi@gmail.com",
            "username" => "budi_santoso",
            "password" => bcrypt("AAAAa1!"),
            "specialization" => "umum",
            "status" => "1",
            "registration_number" => "123126",
            "phone" => "081237010266",
            "gender" => "L",
            "birthdate" => "1985-05-15",
            "address" => "Jl. Cipto Mangunkusumo",
            "image" => "/uploads/img/budi_santoso.png",
        ]);

        // set middleware yang login ke website adalah dokter
        Auth::guard('doctor')->login($doctor);

        // mendapatkan data review
        $response = $this->get('/dokter/data-review');

        // mengecek apakah data review ditampilkan
        $response->assertStatus(200);
    }
}
