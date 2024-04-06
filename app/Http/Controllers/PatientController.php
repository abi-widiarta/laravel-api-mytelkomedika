<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Report;
use App\Models\Review;
use App\Models\Patient;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PatientController extends AuthController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $patients = Patient::query();

        if (request('search')) {
            $patients->where('name', 'like', '%' . request('search') . '%')->orWhere('student_id', 'like', '%' . request('search') . '%');
        }

        return view("admin.patient_data", ["patients" => $patients->paginate(10)->withQueryString()]);
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


        $reservations = Reservation::where('patient_id', Auth::user()->id)->where('status', 'approved');
    
        $daftar_reservasi = $reservations->paginate(3);

        $recommended_doctors = Doctor::orderBy('rating', 'desc')
        ->take(3)
        ->get();

        return view('client.dashboard', 
        [
            'daftar_reservasi' => $daftar_reservasi,
            'recommended_doctors' => $recommended_doctors,
            "tanggal_hari_ini" => Carbon::now()->addHours(9)->format('d-m-Y'),
            "jam_mulai_hari_ini" => $jam_mulai,
            "jam_selesai_hari_ini" => $jam_selesai,
            "antrian_umum" => $antrian_umum == null ? '-' : $antrian_umum,
            "antrian_mata" => $antrian_mata == null ? '-' : $antrian_mata,
            "antrian_gigi" => $antrian_gigi == null ? '-' : $antrian_gigi,
        ]);
    }

    public function showDoctors(Request $request) {
        $doctors = Doctor::when($request->poli, function($query) use ($request) {
            return $query->where('specialization', $request->poli);
        })->whereHas('schedule_time', function ($query) {
            $query->whereNotNull('schedule_time_id'); // Sesuaikan dengan nama kolom di tabel pivot
        });

        $doctors = $doctors->paginate(10)->withQueryString();

        $ratings = [];

        foreach ($doctors as $doctor) {
            $rating = number_format(Review::where('doctor_id', $doctor->id)->avg('rating'), 1);
            $ratings[] = $rating;
        }
        
        return view('client.make_reservation',["doctors" => $doctors, "ratings" => $ratings]);
    }

    public function destroy(Request $request) {
        Patient::where('id', $request->id)->delete();

        return redirect('/admin/data-pasien')->with('success', 'Data berhasil dihapus!');
    }

    public function edit($username) {
        try {
            $patient = Patient::where('username',$username)->firstOrFail();

            return view('admin.patient_data_edit',["patient" => $patient]);
        } catch (ModelNotFoundException $exception) {
            return view("client.notFound",["exception" => $exception]);
        }

        
    }

    public function update(Request $request,$id) {
        $patient = Patient::findOrFail($id);

        try {
            $request->validate([
                'no_hp' => 'required|min:11|max:13',
                'alamat' => 'required|max:256',
                'jenis_kelamin' => 'required',
                'tanggal_lahir' => 'required',
                'password' => 'nullable|max:15|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
            ]);

            if ($request->password == null) {
                $patient->update([
                    "phone" => $request->no_hp,
                    "gender" => $request->jenis_kelamin,
                    "birthdate" => $request->tanggal_lahir,
                    "address" => $request->alamat
                ]);
            } else {
                $patient->update([
                    "phone" => $request->no_hp,
                    "gender" => $request->jenis_kelamin,
                    "birthdate" => $request->tanggal_lahir,
                    "address" => $request->alamat,
                    "password" => bcrypt($request->password) 
                ]);
            }
    
            $patient = Patient::findOrFail($request->id);
    
    
            return back()->with('success','Data berhasil diupdate!');
        } catch (ValidationException $e) {
            return redirect('/admin/data-pasien/edit/' . $request->username)->with('toast_error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect('/admin/data-pasien/edit/' . $request->username)->withErrors(['error' => 'Terjadi kesahalan!']);
        }
    }

    public function profileEdit() {
        return view("client.profile");
    }

    public function profileUpdate(Request $request) {
        try {
            $request->validate([
                'phone' => 'required|numeric|digits_between:11,13',
                'address' => 'required|string|max:256',
                'birthdate' => 'required|date',
                'gender' => 'required',
            ]);
    
           Patient::findOrFail($request->id)->update([
                "phone" => $request->phone,
                "gender" => $request->gender,
                "birthdate" => $request->birthdate,
                "address" => $request->address
            ]);

    
            return redirect('/profile')->with('success','Update profil berhasil!');
        } catch (ValidationException $e) {
            // Tangkap exception jika validasi gagal
            return redirect('/profile')->with('toast_error', $e->getMessage());
        } catch (\Exception $e) {
            // Tangkap exception lain jika terjadi kesalahan lainnya
            return redirect('/profile')->withErrors(['error' => 'Terjadi kesalahan!']);
        }
    }

    public function showReservations(Request $request) {
        $reservations = Reservation::where('patient_id', Auth::user()->id)
            ->where('status','approved');
    
        $reservations->when($request->poli, function ($query) use ($request) {
            $query->whereHas('doctor', function ($subquery) use ($request) {
                $subquery->where('specialization', $request->poli);
            });
        });
    
        $daftar_reservasi = $reservations->get();

        
    
        return view('client.my_reservation', ['daftar_reservasi' => $daftar_reservasi]);
    }

    public function showResults() {

        $daftar_pemeriksaan = Reservation::with('doctor')->where('patient_id', Auth::user()->id)->where('status','completed')->orderBy('updated_at', 'desc');

        return view('client.reservation_result',['daftar_pemeriksaan'=> $daftar_pemeriksaan->paginate(6) ]);
    }

    public function showResultDetail($id) {
        $report = Report::with('reservation')->where('reservation_id',$id)->first();

        if(!$report) {
            return redirect()->back()->withToastError('Laporan Belum Tersedia');
        }

        return view('client.reservation_result_detail', ["report" => $report]);
    }

    public function showResultDetailPDF($id) {
        $report = Report::with('reservation')->where('reservation_id',$id)->first();
        

        $obatList = explode("\n", $report->medications);
    

        $pdf = Pdf::loadView('client.reservation_result_detail_pdf',["report" => $report, "daftar_obat" => $obatList]);
        return $pdf->stream('TelkoMedika_Hasil Pemeriksaan_' . $report->reservation->patient->student_id . '.pdf');

        return view('client.reservation_result_detail_pdf', ["report" => $report, "daftar_obat" => $obatList]);
    }

    public function showDoctorDetail($username) {
        $doctor = Doctor::where('username',$username)->first();

        $reviews = Review::with(['doctor','report'])->where('doctor_id',$doctor->id) ->orderBy('created_at', 'desc')->take(3)->get();
        return view('client.make_reservation_detail',["doctor" => $doctor, "schedules" => DoctorSchedule::where('doctor_id',$doctor->id)->get(),"reviews" =>$reviews]);
    }

    public function makeReview(Request $request,$id) {
        
        $request->validate([
            'comment'=> 'required',
            'rating' => 'required|max:256',
        ],[
            'comment.required' => 'Harap isi comment',
            'rating.required' => 'Harap isi rating',
        ]);

        
        if(Review::where('report_id',$id)->count() == 1) {
            Review::where('report_id',$id)->update([
                'doctor_id' => $request->doctor_id,
                'report_id'=> $id,
                'comment'=> $request->comment,
                'rating' => $request->rating,
            ]);

            Doctor::find($request->doctor_id)->update(
                [
                    'rating' => number_format(Review::where('doctor_id', $request->doctor_id)->avg('rating'), 1),
                ]
            );

            return redirect()->back()->with('success', 'Review berhasil diupdate');
        };

        Review::create([
            'doctor_id' => $request->doctor_id,
            'report_id'=> $id,
            'comment'=> $request->comment,
            'rating' => $request->rating,
        ]);

        Doctor::find($request->doctor_id)->update(
            [
                'rating' => number_format(Review::where('doctor_id', $request->doctor_id)->avg('rating'), 1),
                'total_review' => Review::where('doctor_id', $request->doctor_id)->count()
            ]
        );
        
        

        return redirect()->back()->with('success', 'Review berhasil dikirim');

    }

}
