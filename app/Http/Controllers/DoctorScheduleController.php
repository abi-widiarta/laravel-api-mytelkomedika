<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\ScheduleTime;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreDoctorScheduleRequest;
use App\Http\Requests\UpdateDoctorScheduleRequest;

class DoctorScheduleController extends Controller
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
            ])->get('http://127.0.0.1:8000/api/admin/jadwal-dokter', [
                'search' => $request->search,
            ]);

            $data = $response->json();
            $objectData = json_decode(json_encode($data));

            return view('admin.doctor_schedule', ["schedules" => $objectData->data]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }      
    }

    public function create(Request $request) {
        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');
        
            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/admin/jadwal-dokter/create');

            $data = $response->json();
            $objectData = json_decode(json_encode($data));

            return view('admin.doctor_schedule_add', ["doctors"=> $objectData->data->doctors,"schedule_time" => $objectData->data->schedule_time,"schedule_status" => $objectData->data->schedule_status]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'tes']);
        }      
    }

    public function store(Request $request) {
        try {
            // Mengambil token dari session atau tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Panggil API dengan token bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/admin/jadwal-dokter/store', [
                'dokter' => $request->dokter,
                'schedule_time_id' => $request->schedule_time_id,
                'hari' => $request->hari,
                'max_patient' => 30,
                'end_date' => $request->tanggal_berlaku_sampai,
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', $response['message']);
            } else {
                return redirect()->back()->withErrors(['error' => $response['message']]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $response['message']]);
        }
    }

    public function edit(Request $request) {
        try {
            // Mengambil token dari session atau tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Panggil API dengan token bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/admin/jadwal-dokter/edit', [
                'id' => $request->id,
            ]);

            $data = $response->json();
            $objectData = json_decode(json_encode($data));

            return view('admin.doctor_schedule_edit', ["schedule"=> $objectData->data->schedule,"schedule_time" => $objectData->data->schedule_time,"schedule_status" => $objectData->data->schedule_status]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $response['message']]);
        }
    }

    public function update(Request $request) {
        try {
            // Mengambil token dari session atau tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Panggil API dengan token bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/admin/jadwal-dokter/update', [
                'dokter' => $request->dokter,
                'id' => $request->id,
                'schedule_time_id' => $request->schedule_time_id,
                'hari' => $request->hari,
                'tanggal_berlaku_sampai' => $request->tanggal_berlaku_sampai,
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', $response['message']);
            } else {
                return redirect()->back()->withErrors(['error' => $response['message']]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => "Gagal update jadwal dokter"]);
        }

        return redirect('/admin/jadwal-dokter/edit/' . $id)->with('success','Jadwal dokter berhasil diupdate!');
    }

    public function destroy($id) {

        DoctorSchedule::where('id', $id)->delete();

        return redirect('/admin/jadwal-dokter')->with('success', 'Jadwal dokter berhasil dihapus!');

    }

}
