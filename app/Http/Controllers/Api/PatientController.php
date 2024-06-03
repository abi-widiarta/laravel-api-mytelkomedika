<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Report;
use App\Models\Review;
use App\Models\Patient;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\DoctorSchedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index(Request $request) {
        $patients = Patient::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $patients->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('student_id', 'like', '%' . $searchTerm . '%');
            });
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Patients data retrieved successfully',
            'data' => $patients->get()
        ]);
    }

    public function dashboard(Request $request) {
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


        $reservations = Reservation::with(['doctor'])->where('patient_id', $request->id)->where('status', 'approved');
    
        $daftar_reservasi = $reservations->get();

        $recommended_doctors = Doctor::orderBy('rating', 'desc')
        ->take(3)
        ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Dashboard data retrieved successfully',
            'data' => [
                'daftar_reservasi' => $daftar_reservasi,
                'recommended_doctors' => $recommended_doctors,
                "tanggal_hari_ini" => Carbon::now()->addHours(9)->format('d-m-Y'),
                "jam_mulai_hari_ini" => $jam_mulai,
                "jam_selesai_hari_ini" => $jam_selesai,
                "antrian_umum" => $antrian_umum == null ? '-' : $antrian_umum,
                "antrian_mata" => $antrian_mata == null ? '-' : $antrian_mata,
                "antrian_gigi" => $antrian_gigi == null ? '-' : $antrian_gigi,
            ]
        ], 200);
    }

    public function showDoctors(Request $request)
    {
        $doctors = Doctor::when($request->poli, function($query) use ($request) {
            return $query->where('specialization', $request->poli);
        })->whereHas('schedule_time', function ($query) {
            $query->whereNotNull('schedule_time_id'); // Sesuaikan dengan nama kolom di tabel pivot
        });

        $doctors = $doctors->get();

        $ratings = [];

        foreach ($doctors as $doctor) {
            $rating = number_format(Review::where('doctor_id', $doctor->id)->avg('rating'), 1);
            $ratings[] = $rating;
        }
        

        return response()->json([
            'status' => 'success',
            'message' => 'Doctors data retrieved successfully',
            'data' => $doctors,
        ]);
    }

    public function showDoctorDetail(Request $request) {
        $doctor = Doctor::with('schedule_time')->where('username',$request->username)->first();

        $reviews = Review::with(['doctor','report.reservation.patient'])->where('doctor_id',$doctor->id) ->orderBy('created_at', 'desc')->take(3)->get();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Doctors data retrieved successfully',
            'data' => [
                "doctor" => $doctor, 
                "schedules" => DoctorSchedule::with('schedule_time')->where('doctor_id',$doctor->id)->get(),
                "reviews" =>$reviews
            ],
        ]);
    }

    public function showReservations(Request $request) {
        $reservations = Reservation::with('doctor')->where('patient_id', Auth::user()->id)
            ->where('status','approved');
    
        $reservations->when($request->poli, function ($query) use ($request) {
            $query->whereHas('doctor', function ($subquery) use ($request) {
                $subquery->where('specialization', $request->poli);
            });
        });
    
        $daftar_reservasi = $reservations->get();

        
        return response()->json([
            'status' => 'success',
            'message' => 'Doctors data retrieved successfully',
            'data' => $daftar_reservasi,
        ]);
    }

    public function showResults(Request $request) {

        $daftar_pemeriksaan = Reservation::with(['doctor','report'])->where('patient_id', $request->id)->where('status','completed')->orderBy('updated_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Doctors data retrieved successfully',
            'data' => $daftar_pemeriksaan,
        ]);
        // return view('client.reservation_result',['daftar_pemeriksaan'=> $daftar_pemeriksaan->paginate(6) ]);
    }

    public function showResultDetail(Request $request) {
        $report = Report::with(['reservation.doctor','reservation.payment'])->where('reservation_id', $request->id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Doctors data retrieved successfully',
            'data' => $report,
        ]);
        // return view('client.reservation_result_detail', ["report" => $report]);
    }

    public function makeReview(Request $request) {
        
        $request->validate([
            'comment'=> 'required',
            'rating' => 'required|max:256',
        ],[
            'comment.required' => 'Harap isi comment',
            'rating.required' => 'Harap isi rating',
        ]);

        
        if(Review::where('report_id',$request->id)->count() == 1) {
            Review::where('report_id',$request->id)->update([
                'doctor_id' => $request->doctor_id,
                'report_id'=>$request->id,
                'comment'=> $request->comment,
                'rating' => $request->rating,
            ]);

            Doctor::find($request->doctor_id)->update(
                [
                    'rating' => number_format(Review::where('doctor_id', $request->doctor_id)->avg('rating'), 1),
                ]
            );

            return response()->json(['status' => 'success', 'message' => 'Review berhasil diupdate'], 200);
        };

        Review::create([
            'doctor_id' => $request->doctor_id,
            'report_id'=> $request->id,
            'comment'=> $request->comment,
            'rating' => $request->rating,
        ]);

        Doctor::find($request->doctor_id)->update(
            [
                'rating' => number_format(Review::where('doctor_id', $request->doctor_id)->avg('rating'), 1),
                'total_review' => Review::where('doctor_id', $request->doctor_id)->count()
            ]
        );
        
        return response()->json(['status' => 'success', 'message' => 'Review berhasil dikirim'], 200);
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
}
