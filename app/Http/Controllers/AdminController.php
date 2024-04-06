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
use App\Http\Controllers\AuthController;

class AdminController extends AuthController
{
    public function index() {
        $admins = Admin::paginate(10);
        return view('admin.admin_data',['admins' => $admins]);
    }

    public function create() {
        return view('admin.admin_data_add');
    }

    public function edit($id) {
        $admin = Admin::findOrFail($id);

        return view('admin.admin_data_edit',['admin' => $admin]);
    }

    public function update(Request $request,$id) {
        $admin = Admin::findOrFail($id);

        if ($request->password == null) {
            $admin->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ]);
        } else {
            $admin->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect('/admin/data-admin')->with("success","Data berhasil diupdate!");
    }

    public function store(Request $request) {
        Admin::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect('/admin/data-admin')->with("success","Data berhasil ditambah!");
    }

    public function destroy($id) {

        Admin::where('id', $id)->delete();

        return redirect('/admin/data-admin')->with('success', 'Data berhasil dihapus!');
    }


    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|min:3|max:15',
            'password' => 'required|max:15',
        ]);
        
        if (Auth::guard('admin')->attempt($credentials)) {
            
            $request->session()->regenerate();  
            
            return redirect('/admin/dashboard')->with('success','Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username dan password salah',
        ])->onlyInput('username');
    }

    
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function dashboard(DoctorChart $doctor_chart, ReviewChart $review_chart, Request $request) {
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
            echo "Rentang waktu tidak valid";
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
        $menunggu_pembayaran = Payment::where('amount','!=','0')->where('status',0)->get();
        
        return view('admin.dashboard', 
        [
            "doctor_chart" => $doctor_chart->build(),
            "review_chart" => $review_chart->build(),
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
        ]);
    }
}
