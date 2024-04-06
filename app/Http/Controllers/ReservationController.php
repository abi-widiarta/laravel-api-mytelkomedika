<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Report;
use App\Models\Patient;
use App\Models\Reservation;
use App\Models\ScheduleTime;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $reservation = Reservation::with('doctor')
        ->when($request->tanggal_reservasi, function ($query) use ($request) {
            $originalDate = $request->tanggal_reservasi;
            $carbonDate = Carbon::createFromFormat('m/d/Y', $originalDate);
            $formattedDate = $carbonDate->format('Y-m-d');
            $query->where('date', $formattedDate);
        }, function ($query) {
            $query->where('date', Carbon::now()->addHours(7)->format('Y-m-d'));
        })
        ->when($request->poli, function ($query) use ($request) {
            $query->whereHas('doctor', function ($subquery) use ($request) {
                $subquery->where('specialization', $request->poli);
            });
        })
        ->when($request->jam_mulai, function ($query) use ($request) {
            $query->where('start_hour', $request->jam_mulai);
        }, function ($query) {
            $query->where('date', "07:00:00");
        })
        ->where('status', '!=', 'canceled') 
        ->paginate(10);

    return view('admin.queue', ["daftar_jam" => ScheduleTime::all(), "reservations" => $reservation]);
    }

    public function completeReservation($id) {
        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            "status" => 'completed',
        ]);

        $reservation->doctor->update(
            [
                'total_pasien' => Reservation::where('doctor_id', $reservation->doctor->id)->where('status', 'completed')->count(),
            ]
        );

        return redirect()->back()->with('success', 'Reservasi berhasil diselesaikan');

    }

    public function showReportForm($id) {
        // dd(Report::where('reservation_id',$id)->first() != null);
        if(Report::where('reservation_id',$id)->first() == null) {
            return view('admin.result_form',["reservation" => Reservation::with(['patient','doctor'])->findOrFail($id)]);
        } else {
            return view('admin.result_form_edit',["report" => Report::where('reservation_id',$id)->first()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$id)
    {

        // $request->validate([
        //     'tanggal_reservasi' => 'required',
        //     'jam' => 'required',
        //     'keluhan_awal' => 'required',
        // ],[
        //     'tanggal_reservasi.required' => 'Harap isi tanggal reservasi',
        //     'jam.required' => 'Harap pilih jam reservasi',
        //     'keluhan_awal.required' => 'Harap isi keluhan awal',
        // ]);

        $tanggal = date('Y-m-d', strtotime($request->tanggal_reservasi));
        $jamArray = explode(' - ', $request->jam);
        $jam_mulai = $jamArray[0];
        $jam_selesai = $jamArray[1];

        $patient = Patient::find(Auth::user()->id);
        
        $waktu_sekarang = date("H:i:s");
        $waktu_sekarang_final = date("H:i:s", strtotime($waktu_sekarang) + 7 * 3600);
        $dateTime_mulai = \DateTime::createFromFormat('H:i', $jam_mulai);
        $dateTime_selesai = \DateTime::createFromFormat('H:i', $jam_selesai);

        // dd($waktu_sekarang,$dateTime_mulai,$dateTime_selesai);
        // dd($request->tanggal_reservasi,Carbon::today()->format('m/d/Y'));

        $nextQueueNumber = $this->calculateNextQueueNumber($id, $tanggal);

        // if($patient->gender == null && $patient->phone == null && $patient->address == null && $patient->birthdate == null) {
        //     return redirect()->back()->with('error','Harap lengkapi profil');
        // };

        //  dd($jam_mulai,$waktu_ditambahkan);
        // dd($waktu_sekarang_final >= $jam_selesai );
        if (($waktu_sekarang_final >= $jam_selesai) && ($request->tanggal_reservasi == Carbon::today()->format('m/d/Y'))) {
            return redirect()->back()->with('error','Waktu tidak valid');
        }

        if(Reservation::where('start_hour',$jam_mulai)
                        ->where('end_hour',$jam_selesai)
                        ->where('date',$tanggal)
                        ->where('patient_id',Auth::user()->id)
                        ->where('status','!=','canceled')->first()) {
            return redirect('/lakukan-reservasi')->with('error','Anda telah melakukan booking ini!');
        }

        if($nextQueueNumber == 21) {
            return redirect('/lakukan-reservasi')->with('error','Kuota Full!');
        }

        if(Reservation::where('patient_id',Auth::user()->id)->where('status','approved')->count() == 3) {
            return redirect()->back()->with('error','Anda telah mencapai kuota maksimal 3 reservasi');
        };

        $user = Patient::find(Auth::user()->id);
        $user->doctors()->attach($id,['date' => $tanggal,'start_hour' => $jam_mulai,'end_hour' => $jam_selesai,'status' => 'approved', 'queue_number' => $nextQueueNumber]);


        return redirect('/lakukan-reservasi')->withToastSuccess('Reservation berhasi dibuat!');
    }

    // Logika untuk menghitung nomor antrian secara manual
    private function calculateNextQueueNumber($doctorId, $tanggal)
    {
        // dd($doctorId, $tanggal);
        
        $lastReservation = Reservation::where('doctor_id', $doctorId)
        ->where('date', $tanggal)
        ->where('status','!=','canceled')
        ->orderBy('queue_number', 'desc')
        ->first();
        

        $nextQueueNumber = $lastReservation ? $lastReservation->nomor_antrian + 1 : 1;

        return $nextQueueNumber;
    }

    public function cancel(Request $request, $reservationId) {
        $reservation = Reservation::find($reservationId);

        // Simpan nomor antrian yang akan dihapus
        $canceledQueueNumber = $reservation->queue_number;

        // Batalkan reservasi
        $reservation->update(['status' => 'canceled']);

        // Hapus nomor antrian yang dibatalkan
        Reservation::where('doctor_id', $reservation->doctor_id)
            ->where('date', $reservation->date)
            ->where('queue_number', '>', $canceledQueueNumber)
            ->decrement('queue_number');

        // Redirect atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
    
}
