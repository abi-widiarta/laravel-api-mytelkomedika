<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\ScheduleTime;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use App\Http\Controllers\Controller;

class DoctorScheduleController extends Controller
{
    public function index() {
        $schedules = DoctorSchedule::with(['doctor','schedule_time'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Doctor schedules data retrieved successfully',
            'data' => $schedules
        ]);
    }

    public function create() {
        $categories = ['umum', 'mata', 'gigi'];
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

        $resultArray = [];

        foreach ($categories as $category) {
            foreach ($days as $day) {
                $jam = [];

                for ($i=1; $i <= 5; $i++) { 
                    $schedule_exist = DoctorSchedule::with('schedule_time')->where('schedule_time_id',$i)->where('day', $day)
                        ->whereHas('doctor', function ($query) use ($category) {
                            $query->where('specialization', $category);
                        })
                        ->first();

                    if ($schedule_exist != null) {
                        $jam_mulai = Carbon::createFromFormat('H:i:s', $schedule_exist->schedule_time->start_hour)->format('H:i');
                        $jam_selesai = Carbon::createFromFormat('H:i:s', $schedule_exist->schedule_time->end_hour)->format('H:i');
                        $jam[] = $jam_mulai . "-" . $jam_selesai;
                    } else {
                        $jam[] = "-";
                    }
                }
                $resultArray[$category][$day] = $jam;
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Doctor schedule creation data retrieved successfully',
            'data' => [
                'doctors' => Doctor::all(),
                'schedule_time' => ScheduleTime::all(),
                'schedule_status' => $resultArray
            ]
        ]);
    }

    public function store(Request $request) {
        if (DoctorSchedule::where('schedule_time_id', $request->schedule_time_id)
        ->where('day', $request->hari)
        ->whereHas('doctor', function ($query) use ($request) {
            $query->where('specialization', Doctor::find($request->dokter)->specialization);
        })
        ->first() != null) {
        return response()->json([
            'status' => 'error',
            'message' => 'Jadwal sudah terisi'
        ], 400);
    }

    DoctorSchedule::create([
        "doctor_id" => $request->dokter,
        "schedule_time_id" => $request->schedule_time_id,
        "day" => $request->hari,
        "end_date" => $request->tanggal_berlaku_sampai,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Data added successfully'
    ], 200);
    }

    public function edit(Request $request) {
        $categories = ['umum', 'mata', 'gigi'];
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
    
        $resultArray = [];
    
        foreach ($categories as $category) {
            foreach ($days as $day) {
                $jam = [];
    
                for ($i=1; $i <= 5; $i++) { 
                    $schedule_exist = DoctorSchedule::with('schedule_time')->where('schedule_time_id',$i)->where('day', $day)
                        ->whereHas('doctor', function ($query) use ($category) {
                            $query->where('specialization', $category);
                        })
                        ->first();
    
                    if ($schedule_exist != null) {
                        $jam_mulai = Carbon::createFromFormat('H:i:s', $schedule_exist->schedule_time->start_hour)->format('H:i');
                        $jam_selesai = Carbon::createFromFormat('H:i:s', $schedule_exist->schedule_time->end_hour)->format('H:i');
                        $jam[] = $jam_mulai . "-" . $jam_selesai;
                    } else {
                        $jam[] = "-";
                    }
                }
                $resultArray[$category][$day] = $jam;
            }
        }
    
        $schedule = DoctorSchedule::with(['doctor'])->findOrFail($request->id);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Doctor schedule edit data retrieved successfully',
            'data' => [
                'schedule' => $schedule,
                'schedule_time' => ScheduleTime::all(),
                'schedule_status' => $resultArray
            ]
        ]);
    }

    public function update(Request $request) {
        $schedule = DoctorSchedule::findOrFail($request->id);

        if (DoctorSchedule::where('schedule_time_id', $request->schedule_time_id)
        ->where('day', $request->hari)
        ->whereHas('doctor', function ($query) use ($request) {
            $query->where('specialization', Doctor::find($request->dokter)->specialization);
        })
        ->first() != null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jadwal sudah terisi'
            ], 400);
        }

        $schedule->update([
            "schedule_time_id" => $request->schedule_time_id,
            "day" => $request->hari,
            "end_date" => $request->tanggal_berlaku_sampai,
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal dokter berhasil diupdate!'
        ]);
    }
}
