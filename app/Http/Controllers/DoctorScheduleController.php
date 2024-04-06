<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\ScheduleTime;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use App\Http\Requests\StoreDoctorScheduleRequest;
use App\Http\Requests\UpdateDoctorScheduleRequest;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $schedules =  DoctorSchedule::with('doctor')->paginate(10);

        return view('admin.doctor_schedule', ["schedules" => $schedules]);
    }

    public function create() {
        $categories = ['umum', 'mata', 'gigi'];
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];


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
        return view('admin.doctor_schedule_add', ["doctors"=> Doctor::all(),"schedule_time" => ScheduleTime::all(),"schedule_status" => $resultArray]);
    }

    public function store(Request $request) {
        if(DoctorSchedule::where('schedule_time_id', $request->schedule_time_id)
                ->where('day', $request->hari)
                ->whereHas('doctor', function ($query) use ($request) {
                    $query->where('specialization', Doctor::find($request->dokter)->specialization);
                })
                ->first()
                
                
            != null) {
                return redirect()->back()->withToastError('Jadwal sudah terisi');
            };

            // dd($request);

            DoctorSchedule::create([
                "doctor_id" => $request->dokter,
                "schedule_time_id" => $request->schedule_time_id,
                "day" => $request->hari,
                "end_date" => $request->tanggal_berlaku_sampai,
            ]);

        return redirect()->back()->with('success','Data added successfully!');
    }

    public function edit($id) {
        $categories = ['umum', 'mata', 'gigi'];
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];


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
        return view('admin.doctor_schedule_edit', ["schedule"=> DoctorSchedule::findOrFail($id),"schedule_time" => ScheduleTime::all(),"schedule_status" => $resultArray]);
    }

    public function update(Request $request, $id) {
        // dd($request);
        $schedule = DoctorSchedule::findOrFail($id);

        $schedule->update([
            "schedule_time_id" => $request->schedule_time_id,
            "day" => $request->hari,
            "end_date" => $request->tanggal_berlaku_sampai,
        ]);

        return redirect('/admin/jadwal-dokter/edit/' . $id)->with('success','Jadwal dokter berhasil diupdate!');
    }

    public function destroy($id) {

        DoctorSchedule::where('id', $id)->delete();

        return redirect('/admin/jadwal-dokter')->with('success', 'Jadwal dokter berhasil dihapus!');

    }

}
