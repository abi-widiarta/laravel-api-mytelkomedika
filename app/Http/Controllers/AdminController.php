<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin;
use App\Charts\DoctorChart;
use App\Charts\ReviewChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthController;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    
    public function index(Request $request) {
        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/admin/data-admin');

            $data = $response->json();
            $objectData = json_decode(json_encode($data));

            return view('admin.admin_data',['admins' => $objectData->data]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve data.']);
        }      

    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            $response = Http::post('http://127.0.0.1:8000/api/admin/login', [
                'username' => $request->username,
                'password' => $request->password,
            ]);

            $data = $response->json();

            // Simpan token dalam session
            session(['token' => $data['token']]);
            session(['user' => $data['user']]);

            // Redirect ke dashboard dengan menyertakan token dalam session
            return redirect('/admin/dashboard');
        } catch (\Exception $e) {
            // Jika login gagal, arahkan kembali ke halaman login dengan pesan error
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }
    }

    
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function dashboard(Request $request, DoctorChart $doctor_chart, ReviewChart $review_chart) {

        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/admin/dashboard');

            $data = $response->json();
            $objectData = json_decode(json_encode($data));

            // dd($objectData);
            
            return view('admin.dashboard', 
            [
                "doctor_chart" => $doctor_chart->build(),
                "review_chart" => $review_chart->build(),
                "total_pasien" => $objectData->data->total_pasien,
                "total_dokter" => $objectData->data->total_dokter,
                "total_pembayaran" => $objectData->data->total_pembayaran,
                "tanggal_hari_ini" => Carbon::now()->addHours(9)->format('d-m-Y'),
                "jam_mulai_hari_ini" => $objectData->data->jam_mulai_hari_ini,
                "jam_selesai_hari_ini" => $objectData->data->jam_selesai_hari_ini,
                "antrian_umum" => $objectData->data->antrian_umum == null ? '-' : $objectData->data->antrian_umum,
                "antrian_mata" => $objectData->data->antrian_mata == null ? '-' : $objectData->data->antrian_mata,
                "antrian_gigi" => $objectData->data->antrian_gigi == null ? '-' : $objectData->data->antrian_gigi,
                "menunggu_laporan" => $objectData->data->menunggu_laporan,
                "menunggu_pembayaran" => $objectData->data->menunggu_pembayaran
            ]);

            // return view('doctor.dashboard', ['reservations' => $reservations['data'],'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }
}
