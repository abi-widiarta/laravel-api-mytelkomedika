<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Review;
use App\Models\Patient;
use App\Models\Payment;
use App\Charts\DoctorChart;
use App\Charts\ReviewChart;
use App\Models\Reservation;
use App\Models\ScheduleTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthController;
use Illuminate\Validation\ValidationException;

class AdminController extends AuthController
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

    public function create() {
        return view('admin.admin_data_add');
    }

    public function edit(Request $request) {
        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/admin/data-admin/edit',[
                'id' => $request->id
            ]);

            $data = $response->json();
            $objectData = json_decode(json_encode($data));

            return view('admin.admin_data_edit',['admin' => $objectData->data]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect('/admin/data-admin')->withErrors(['error' => 'Gagal mendapatkan data admin']);
        }      

        return view('admin.admin_data_edit',['admin' => $admin]);
    }

    public function update(Request $request,$id) {
       

        return redirect('/admin/data-admin')->with("success","Data berhasil diupdate!");
    }

    public function store(Request $request) {
        try {
            // Mengambil token dari session atau tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // dd($request->all());

            // Panggil API dengan token bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/admin/data-admin/store', [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful() && $response['status'] === 'success') {
                // Jika berhasil, kembalikan ke halaman sebelumnya dengan pesan sukses
                return redirect('/admin/data-admin')->withToastSuccess('Berhasil membuat admin!');
            } else {
                return redirect('/admin/data-admin')->withErrors(['error' => $response['message']]);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return redirect()->back()->withErrors(['error' => 'Gagal menambah admin']);
        }

        return redirect('/admin/data-admin')->with("success","Data berhasil ditambah!");
    }

    public function destroy($id) {

        Admin::where('id', $id)->delete();

        return redirect('/admin/data-admin')->with('success', 'Data berhasil dihapus!');
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

            // dd($data);

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

    // public function dashboard(DoctorChart $doctor_chart, ReviewChart $review_chart) {
    //     $total_pasien = Patient::count();
    //     $total_dokter = Doctor::count();

    //     $waktu_sekarang = Carbon::now();
    //     $waktu_sekarang_final = $waktu_sekarang->addHours(7);

    //     $jam_mulai = "";
    //     $jam_selesai = "";


    //     $rentang_waktu = [
    //         ["07:00:00", "09:00:00"],
    //         ["10:00:00", "12:00:00"],
    //         ["13:00:00", "15:00:00"],
    //         ["16:00:00", "18:00:00"],
    //         ["20:00:00", "22:00:00"],
    //     ];

    //     $representasi_rentang = 0; 

    //     foreach ($rentang_waktu as $index => $rentang) {
    //         $mulai = Carbon::createFromFormat('H:i:s', $rentang[0]);
    //         $akhir = Carbon::createFromFormat('H:i:s', $rentang[1]);

    //         if ($waktu_sekarang_final->between($mulai, $akhir)) {
    //             $representasi_rentang = $index;
    //             break;
    //         }

    //         if ($waktu_sekarang_final->lt($mulai) && $representasi_rentang === 0) {
    //             $representasi_rentang = $index;
    //         }
    //     }

    //     if ($representasi_rentang >= 0 && $representasi_rentang < count($rentang_waktu)) {
    //         $jam_mulai = $rentang_waktu[$representasi_rentang][0];
    //         $jam_selesai = $rentang_waktu[$representasi_rentang][1];
    //     } else {
    //         echo "Rentang waktu tidak valid";
    //     }

    //     $total_pembayaran = Payment::where('amount','!=',0)->count();
    //     $antrian_umum = Reservation::where('date', Carbon::now()->addHours(7)->format('Y-m-d'))
    //                     ->where('status','approved')
    //                     ->whereHas('doctor', function ($query) {
    //                         $query->where('specialization', 'umum');
    //                     })
    //                     ->where('start_hour',$jam_mulai)
    //                     ->where('end_hour',$jam_selesai)
    //                     ->max('queue_number');
    //     $antrian_mata = Reservation::where('date', Carbon::now()->addHours(7)->format('Y-m-d'))
    //                     ->where('status','approved')
    //                     ->whereHas('doctor', function ($query) {
    //                         $query->where('specialization', 'mata');
    //                     })
    //                     ->where('start_hour',$jam_mulai)
    //                     ->where('end_hour',$jam_selesai)
    //                     ->max('queue_number');
    //     $antrian_gigi = Reservation::where('date', Carbon::now()->addHours(7)->format('Y-m-d'))
    //                     ->where('status','approved')
    //                     ->whereHas('doctor', function ($query) {
    //                         $query->where('specialization', 'gigi');
    //                     })
    //                     ->where('start_hour',$jam_mulai)
    //                     ->where('end_hour',$jam_selesai)
    //                     ->max('queue_number');

    //     $menunggu_laporan = Reservation::with(['patient','doctor'])->where('status','completed')->doesntHave('report')->get();
    //     $menunggu_pembayaran = Payment::where('amount','!=','0')->where('status',0)->get();
        
    //     return view('admin.dashboard', 
    //     [
    //         "doctor_chart" => $doctor_chart->build(),
    //         "review_chart" => $review_chart->build(),
    //         "total_pasien" => $total_pasien,
    //         "total_dokter" => $total_dokter,
    //         "total_pembayaran" => $total_pembayaran,
    //         "tanggal_hari_ini" => Carbon::now()->addHours(9)->format('d-m-Y'),
    //         "jam_mulai_hari_ini" => $jam_mulai,
    //         "jam_selesai_hari_ini" => $jam_selesai,
    //         "antrian_umum" => $antrian_umum == null ? '-' : $antrian_umum,
    //         "antrian_mata" => $antrian_mata == null ? '-' : $antrian_mata,
    //         "antrian_gigi" => $antrian_gigi == null ? '-' : $antrian_gigi,
    //         "menunggu_laporan" => $menunggu_laporan,
    //         "menunggu_pembayaran" => $menunggu_pembayaran
    //     ]);
    // }
}
