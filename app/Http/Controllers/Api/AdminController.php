<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index() {
        $admins = Admin::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Admins data retrieved successfully',
            'data' => $admins
        ]);
    }

    public function store(Request $request) {
        Admin::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data admin berhasil ditambah!'
        ]);
    }

    public function edit(Request $request) {
        $admin = Admin::findOrFail($request->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data admin edit retrieved successfully',
            'data' => $admin
        ]);
    }

    public function update(Request $request) {
        $admin = Admin::findOrFail($request->id);

        $dataToUpdate = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $dataToUpdate['password'] = bcrypt($request->password);
        }

        $admin->update($dataToUpdate);

        return response()->json([
            'status' => 'success',
            'message' => 'Data admin berhasil diupdate!'
        ]);
    }

    public function destroy(Request $request) {
        $admin = Admin::find($request->id);

        if ($admin) {
            $admin->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data admin tidak ditemukan'
            ], 404);
        }
    }


    public function logout(Request $request) {
        // Memeriksa apakah pengguna telah terautentikasi
        if ($request->user()) {
            // Menghapus token akses saat ini yang diasosiasikan dengan pengguna
            $request->user()->currentAccessToken()->delete();
    
            // Mengembalikan respons berhasil
            return response()->json(['message' => 'Logout berhasil'], 200);
        }
    
        // Jika pengguna tidak terautentikasi, kembalikan respons dengan pesan error
        return response()->json(['message' => 'Tidak ada pengguna terautentikasi'], 401);
    }

    public function dashboard() {
        $total_pasien = Patient::count();
        $total_dokter = Doctor::count();
    
        $waktu_sekarang = Carbon::now();
        $waktu_sekarang_final = $waktu_sekarang->addHours(7);
    
        $jam_mulai = "";
        $jam_selesai = "";
    
        $rentang_waktu = [
            ["07:00:00", "09:00:00"],
            ["10:00:00", "12:00:00"],
            ["13:00:00", "15:00:00"],
            ["16:00:00", "18:00:00"],
            ["20:00:00", "22:00:00"],
        ];
    
        $representasi_rentang = 0; 
    
        foreach ($rentang_waktu as $index => $rentang) {
            $mulai = Carbon::createFromFormat('H:i:s', $rentang[0]);
            $akhir = Carbon::createFromFormat('H:i:s', $rentang[1]);
    
            if ($waktu_sekarang_final->between($mulai, $akhir)) {
                $representasi_rentang = $index;
                break;
            }
    
            if ($waktu_sekarang_final->lt($mulai) && $representasi_rentang === 0) {
                $representasi_rentang = $index;
            }
        }
    
        if ($representasi_rentang >= 0 && $representasi_rentang < count($rentang_waktu)) {
            $jam_mulai = $rentang_waktu[$representasi_rentang][0];
            $jam_selesai = $rentang_waktu[$representasi_rentang][1];
        } else {
            return response()->json(['status' => 'error', 'message' => 'Rentang waktu tidak valid']);
        }
    
        $total_pembayaran = Payment::where('amount','!=',0)->count();
        $antrian_umum = Reservation::where('date', Carbon::now()->addHours(7)->format('Y-m-d'))
                        ->where('status','approved')
                        ->whereHas('doctor', function ($query) {
                            $query->where('specialization', 'umum');
                        })
                        ->where('start_hour',$jam_mulai)
                        ->where('end_hour',$jam_selesai)
                        ->max('queue_number');
        $antrian_mata = Reservation::where('date', Carbon::now()->addHours(7)->format('Y-m-d'))
                        ->where('status','approved')
                        ->whereHas('doctor', function ($query) {
                            $query->where('specialization', 'mata');
                        })
                        ->where('start_hour',$jam_mulai)
                        ->where('end_hour',$jam_selesai)
                        ->max('queue_number');
        $antrian_gigi = Reservation::where('date', Carbon::now()->addHours(7)->format('Y-m-d'))
                        ->where('status','approved')
                        ->whereHas('doctor', function ($query) {
                            $query->where('specialization', 'gigi');
                        })
                        ->where('start_hour',$jam_mulai)
                        ->where('end_hour',$jam_selesai)
                        ->max('queue_number');
    
        $menunggu_laporan = Reservation::with(['patient','doctor'])->where('status','completed')->doesntHave('report')->get();
        $menunggu_pembayaran = Payment::with(['reservation','reservation.patient','reservation.doctor'])->where('amount','!=','0')->where('status',0)->get();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Dashboard data retrieved successfully',
            'data' => [
                "total_pasien" => $total_pasien,
                "total_dokter" => $total_dokter,
                "total_pembayaran" => $total_pembayaran,
                "tanggal_hari_ini" => Carbon::now()->addHours(9)->format('d-m-Y'),
                "jam_mulai_hari_ini" => $jam_mulai,
                "jam_selesai_hari_ini" => $jam_selesai,
                "antrian_umum" => $antrian_umum == null ? '-' : $antrian_umum,
                "antrian_mata" => $antrian_mata == null ? '-' : $antrian_mata,
                "antrian_gigi" => $antrian_gigi == null ? '-' : $antrian_gigi,
                "menunggu_laporan" => $menunggu_laporan,
                "menunggu_pembayaran" => $menunggu_pembayaran
            ]
        ]);
    }
}
