<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        try {
            
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/admin/data-pasien');

            $data = $response->json();
            $objectData = json_decode(json_encode($data));

            return view('admin.patient_data', ["patients" => $objectData->data]);
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
            $response = Http::post('http://127.0.0.1:8000/api/login', [
                'username' => $request->username,
                'password' => $request->password,
            ]);
    
            $data = $response->json();
    
            // Simpan token dalam session
            session(['token' => $data['token']]);
            session(['user' => $data['user']]);
    
            // dd($data);
    
            // Redirect ke dashboard dengan menyertakan token dalam session
            return redirect('/dashboard');
        } catch (\Exception $e) {
            // Jika login gagal, arahkan kembali ke halaman login dengan pesan error
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
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
            ])->get('http://127.0.0.1:8000/api/dashboard', [
                'id' => $user['id'],
            ]);

            $data = $response->json();
            $objectData = json_decode(json_encode($data));

            return view('client.dashboard', ['data' => $objectData->data,'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }

    public function showDoctors(Request $request) {
        try {
            
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/lakukan-reservasi',[
                'poli' => $request->poli,
            ]);

            $data = $response->json();

            return view('client.make_reservation', ['data' => $data['data'],'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }        
    }

    public function showReservations(Request $request) {
        try {
            
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // dd($token);

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/reservasi-saya',[
                'poli' => $request->poli,
            ]);

            $data = $response->json();

            $objectData = json_decode(json_encode($data));

            // dd($objectData);
            return view('client.my_reservation', ['daftar_reservasi' => $objectData->data,'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }

    public function showResults(Request $request) {
        try {
            
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // dd($token);

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/riwayat-pemeriksaan',[
                'id' => $user['id'],
            ]);

            $data = $response->json();

            // dd($data);

            return view('client.reservation_result', ['daftar_pemeriksaan' => $data['data'],'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
        // return view('client.reservation_result',['daftar_pemeriksaan'=> $daftar_pemeriksaan->paginate(6) ]);
    }

    public function showResultDetail(Request $request) {
        try {
            
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // dd($token);

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/riwayat-pemeriksaan/detail',[
                'id' => $request->id,
            ]);

            $data = $response->json();
            $objectData = json_decode(json_encode($data ));

            return view('client.reservation_result_detail', ['report' => $objectData->data,'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }

    public function showResultDetailPDF($id) {
        $report = Report::with('reservation')->where('reservation_id',$id)->first();
        

        $obatList = explode("\n", $report->medications);
    

        $pdf = Pdf::loadView('client.reservation_result_detail_pdf',["report" => $report, "daftar_obat" => $obatList]);
        return $pdf->stream('TelkoMedika_Hasil Pemeriksaan_' . $report->reservation->patient->student_id . '.pdf');

        return view('client.reservation_result_detail_pdf', ["report" => $report, "daftar_obat" => $obatList]);
    }

    public function showDoctorDetail(Request $request) {
        try {
            
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/lakukan-reservasi/detail',[
                'username' => $request->username,
            ]);

            $data = $response->json();

            return view('client.make_reservation_detail', ['data' => $data['data'],'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }

    public function makeReview(Request $request) {
        try {
            // Mengambil token dari session atau tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Panggil API dengan token bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/review', [
                'id' => $request->id,
                'comment' => $request->comment,
                'rating' => $request->rating,
                'doctor_id' => $request->doctor_id,
            ]);
            
            return redirect()->back()->withToastSuccess($response['message']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $response['message']]);
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
                return redirect('/login')->with('success', 'Anda telah berhasil logout');
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
