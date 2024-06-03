<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Reservation;
use App\Models\ScheduleTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function index(Request $request) {
        $reservation = Reservation::with(['doctor','patient'])
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
        ->get();

    return response()->json([
        'status' => 'success',
        'message' => 'Reservations data retrieved successfully',
        'data' => [
            'reservations' => $reservation,
            'daftar_jam' => ScheduleTime::all()
        ] 
    ]);
    }


    public function store(Request $request)
{
    $tanggal = date('Y-m-d', strtotime($request->tanggal_reservasi));
    $jamArray = explode(' - ', $request->jam);
    $jam_mulai = $jamArray[0];
    $jam_selesai = $jamArray[1];

    $waktu_sekarang = date("H:i:s");
    $waktu_sekarang_final = date("H:i:s", strtotime($waktu_sekarang) + 7 * 3600);

    $nextQueueNumber = $this->calculateNextQueueNumber($request->id, $tanggal,$jam_mulai,$jam_selesai);

    if (($waktu_sekarang_final >= $jam_selesai) && ($request->tanggal_reservasi == Carbon::today()->format('m/d/Y'))) {
        return response()->json(['status' => 'error', 'message' => 'Waktu tidak valid'], 400);
    }

    if (Reservation::where('start_hour', $jam_mulai)
        ->where('end_hour', $jam_selesai)
        ->where('date', $tanggal)
        ->where('patient_id', $request->patient_id)
        ->where('status', '!=', 'canceled')->first()) {
        return response()->json(['status' => 'error', 'message' => 'Anda telah melakukan booking ini!'], 400);
    }

    if ($nextQueueNumber == 21) {
        return response()->json(['status' => 'error', 'message' => 'Kuota Full!'], 400);
    }

    if (Reservation::where('patient_id', $request->patient_id)->where('status', 'approved')->count() == 3) {
        return response()->json(['status' => 'error', 'message' => 'Anda telah mencapai kuota maksimal 3 reservasi'], 400);
    };

    $user = Patient::find($request->patient_id);
    $user->doctors()->attach($request->id, ['date' => $tanggal, 'start_hour' => $jam_mulai, 'end_hour' => $jam_selesai, 'status' => 'approved', 'queue_number' => $nextQueueNumber]);

    return response()->json(['status' => 'success', 'message' => 'Reservation berhasil dibuat'], 200);
}

private function calculateNextQueueNumber($doctorId, $tanggal,$jam_mulai,$jam_selesai)
{   
    $lastReservation = Reservation::where('doctor_id', $doctorId)
    ->where('date', $tanggal)
    ->where('start_hour', $jam_mulai)
    ->where('end_hour', $jam_selesai)
    ->where('status','!=','canceled')
    ->orderBy('queue_number', 'desc')
    ->first();    

    $nextQueueNumber = $lastReservation ? $lastReservation->queue_number + 1 : 1;

    return $nextQueueNumber;
}

public function cancel(Request $request)
{
    $reservation = Reservation::find($request->id);

    if (!$reservation) {
        return response()->json(['status' => 'error', 'message' => 'Reservasi tidak ditemukan'], 404);
    }

    // Simpan nomor antrian yang akan dihapus
    $canceledQueueNumber = $reservation->queue_number;

    // Batalkan reservasi
    $reservation->update(['status' => 'canceled']);

    // Hapus nomor antrian yang dibatalkan
    Reservation::where('doctor_id', $reservation->doctor_id)
        ->where('date', $reservation->date)
        ->where('queue_number', '>', $canceledQueueNumber)
        ->decrement('queue_number');

    // Mengembalikan respons dalam format JSON
    return response()->json(['status' => 'success', 'message' => 'Reservasi berhasil dibatalkan'], 200);
}

public function completeReservation(Request $request) {
    $reservation = Reservation::findOrFail($request->id);
    $reservation->update([
        "status" => 'completed',
    ]);

    $reservation->doctor->update(
        [
            'total_pasien' => Reservation::where('doctor_id', $reservation->doctor->id)->where('status', 'completed')->count(),
        ]
    );

    return response()->json(['status' => 'success', 'message' => 'Reservasi berhasil diselesaikan'], 200);
}
}
