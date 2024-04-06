<?php

namespace Tests\Feature;

use App\Models\Admin;
use Tests\TestCase;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_store_reservation()
    {
        // pembuatan data pasien untuk tes
        $patient = Patient::create( [
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

        // set middleware yang login ke website adalah sebagai pasien
        Auth::guard('web')->login($patient);

        // membuat reservasi
        $reservation = Reservation::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'date' => '2023-12-22',
            'start_hour' => '07:00:00',
            'end_hour' => '09:00:00',
            'status' => 'approved',
            'initial_complaint' => 'sakit kepala, pusing, meriang',
            'queue_number' => 1,
        ]);

        // validasi reservasi yang telah dibuat
        $this->assertInstanceOf(Reservation::class, $reservation);
    }

    public function test_admin_can_complete_reservation()
  {
    // pembuatan data dokter untuk tes
    $admin = Admin::create([
        "name" => "admin_john",
        "email" => "admin_john@gmail.com",
        "username" => "admin_john",
        "password" => bcrypt("AAAAa1!"),
    ]);

    // set middleware yang login ke website adalah dokter
    Auth::guard('admin')->login($admin);

    // membuat data reservasi
    $reservation = Reservation::create([
      'patient_id' => 1,
      'doctor_id' => 1,
      'date' => '2023-12-22',
      'start_hour' => '07:00:00',
      'end_hour' => '09:00:00',
      'status' => 'completed',
      'initial_complaint' => 'sakit kepala, pusing, meriang',
      'queue_number' => 1,
    ]);

    // mendapatkan antrian pemeriksaan
    $response = $this->get('/admin/antrian-pemeriksaan');

    // mengecek apakah antrian pemeriksaan ditampilkan
    $response->assertStatus(200);

    // melengkapi data reservasi
    $response = $this->post('/admin/antrian-pemeriksaan/' . $reservation->id, [
        "status" => "completed",
    ]);

    // mengecek apakah status reservasi berubah menjadi completed
    $reservation = Reservation::find($reservation->id);
    $this->assertEquals("completed", $reservation->status);
  }
}
