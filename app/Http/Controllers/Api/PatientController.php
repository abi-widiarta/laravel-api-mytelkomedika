<?php

namespace App\Http\Controllers\Api;

use App\Models\Doctor;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    public function showDoctors(Request $request) {
        $doctors = Doctor::when($request->poli, function($query) use ($request) {
            return $query->where('specialization', $request->poli);
        })->whereHas('schedule_time', function ($query) {
            $query->whereNotNull('schedule_time_id'); // Sesuaikan dengan nama kolom di tabel pivot
        });

        $doctors = $doctors->paginate(10)->withQueryString();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Doctors data retrieved successfully',
            'data' => $doctors
        ]);
        // return view('client.make_reservation',["doctors" => $doctors, "ratings" => $ratings]);
    }
}
