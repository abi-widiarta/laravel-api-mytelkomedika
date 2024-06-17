<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Review;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DoctorController extends Controller
{
    public function index(Request $request)
    {   
        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/admin/data-dokter', [
                'search' => $request->search,
            ]);

            $data = $response->json();
            $objectData = json_decode(json_encode($data));

            return view('admin.doctor_data',["doctors" => $objectData->data]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }        
    }

    public function dashboard(Request $request)
    {

        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/dokter/dashboard', [
                'poli' => $request->poli,
                'tanggal_reservasi' => $request->tanggal_reservasi,
            ]);

            $reservations = $response->json();

            // dd(auth('sanctum')->user());

            return view('doctor.dashboard', ['reservations' => $reservations['data'],'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }

    public function showQueues(Request $request) {
        try {
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/dokter/antrian-pemeriksaan', [
                'poli' => $request->poli,
                'tanggal_reservasi' => $request->tanggal_reservasi,
            ]);

            $reservation = $response->json();

            return view('doctor.queue',['reservations' => $reservation['data'],"user" => $user]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }

    public function showReviews(Request $request) {
        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/dokter/data-review', [
                'id' => $user['id'],
                'rating' => $request->rating,
            ]);

            $reviews = $response->json();

            return view('doctor.review_data',["reviews" => $reviews['data'], "user" => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }
    
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            $response = Http::post('http://127.0.0.1:8000/api/dokter/login', [
                'username' => $request->username,
                'password' => $request->password,
            ]);

            $data = $response->json();

            // Simpan token dalam session
            session(['token' => $data['token']]);
            session(['user' => $data['user']]);

            // dd($data);

            // Redirect ke dashboard dengan menyertakan token dalam session
            return redirect('/dokter/dashboard');
        } catch (\Exception $e) {
            // Jika login gagal, arahkan kembali ke halaman login dengan pesan error
            return redirect()->back()->withErrors(['error' => "error"]);
        }
    }


    public function logout(Request $request)
    {
        $token = $request->session()->get('token');
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/logout');
            
            // Periksa apakah respons sukses
            if ($response->successful()) {
                // Logout berhasil
                $request->session()->forget('token');
                $request->session()->forget('user');
                return redirect('/dokter/login')->with('success', 'Anda telah berhasil logout');
            } else {
                // Tangani jika logout gagal
                return redirect('/')->with('error', 'Logout gagal: ' . $response->body());
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi kesalahan dalam permintaan HTTP
            return redirect('/')->with('error', 'Terjadi kesalahan dalam melakukan logout: ' . $e->getMessage());
        }
    }
}
