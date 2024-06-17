<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {

        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/admin/antrian-pemeriksaan', [
                'poli' => $request->poli,
                'tanggal_reservasi' => $request->tanggal_reservasi,
                'jam_mulai' => $request->jam_mulai,
            ]);

            $data = $response->json();
            $objectData = json_decode(json_encode($data));


            return view('admin.queue', ["daftar_jam" => $objectData->data->daftar_jam, "reservations" => $objectData->data->reservations]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }      

    
    }

    public function completeReservation(Request $request) {
        try {
            // Mengambil token dari session atau tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Panggil API dengan token bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/admin/antrian-pemeriksaan/complete', [
                'id' => $request->id,
            ]);

            if ($response->successful() && $response['status'] === 'success') {
                // Jika berhasil, kembalikan ke halaman sebelumnya dengan pesan sukses
                return redirect()->back()->withToastSuccess('Reservation berhasil diselesaikan!');
            } else {
                return redirect()->back()->withErrors(['error' => $response['message']]);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return redirect()->back()->withErrors(['error' => 'Gagal membuat reservasi.']);
        }
    }

    public function showReportForm(Request $request) {
        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');
            
            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/admin/antrian-pemeriksaan/hasil-pemeriksaan', [
                'id' => $request->id,
            ]);

            $data = $response->json();
            $objectData = json_decode(json_encode($data));

            // dd($objectData->data);

            if ($objectData->data->report === null) {
                return view('admin.result_form', ["reservation" => $objectData->data->reservation]);
            }else if ($objectData->data->report !== null) {
                return view('admin.result_form_edit', ["report" => $objectData->data->report]);
            }

            // dd($objectData->data->reservation);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }  
    }

    public function store(Request $request)
    {
        
        try {
            // Mengambil token dari session atau tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Panggil API dengan token bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/lakukan-reservasi/detail', [
                'tanggal_reservasi' => $request->tanggal_reservasi,
                'jam' => $request->jam,
                'id' => $request->id,
                'patient_id' => $user['id'],
            ]);

            if ($response->successful() && $response['status'] === 'success') {
                // Jika berhasil, kembalikan ke halaman sebelumnya dengan pesan sukses
                return redirect()->back()->withToastSuccess('Reservation berhasil dibuat!');
            } else {

                // dd($response->body());
                // Jika ada kesalahan, kembalikan ke halaman sebelumnya dengan pesan error dari API
                return redirect()->back()->withErrors(['error' => $response['message']]);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return redirect()->back()->withErrors(['error' => 'Gagal membuat reservasi.']);
        }
    }

    public function cancel(Request $request) {
        try {
            // Mengambil token dari session atau tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Panggil API dengan token bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/reservasi-saya/cancel', [
                'id' => $request->id,
            ]);
            
            return redirect()->back()->withToastSuccess($response['message']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $response['message']]);
        }
    }
    
}
