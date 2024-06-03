<?php

namespace App\Http\Controllers\Api;

use App\Models\Report;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function store(Request $request) {

        $request->validate([
            'berat_badan' => 'required|numeric|max:500',
            'tinggi_badan' => 'required|numeric|min:32|max:250',
            'suhu_badan' => 'required|numeric|min:32|max:42',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'anjuran' => 'required|string',
            'obat' => 'required|string',
        ]);
        
        $biaya = $request->biaya;
        $status = 0;
        
        if($request->biaya == null || $request->biaya == '0') {
            $biaya = "0";
            $status = 1; 
        };

        Report::create([
            'reservation_id' => $request->id,
            'weight' => $request->berat_badan,
            'height'=> $request->tinggi_badan,
            'temperature' => $request->suhu_badan,
            'initial_complaint' => $request->keluhan,
            'diagnosis' => $request->diagnosa,
            'recommendations' => $request->anjuran,
            'medications' => $request->obat,
            'sick_note' =>  $request->surat_dokter == null ? '0' : '1' ,
        ]);

        Payment::create([
            'reservation_id' => $request->id,
            'amount' => $biaya,
            'status' => $status,
        ]);
        

        return response()->json(['status' => 'success', 'message' => 'Data berhasil ditambah!'], 200);
    }

    public function update(Request $request) {
        $report = Report::where('reservation_id',$request->id)->first();
        $payment = Payment::where('reservation_id',$request->id)->first();

        $biaya = $request->biaya;
        $status = 0;
        
        if($request->biaya == null || $request->biaya == '0') {
            $biaya = "0";
            $status = 1; 
        };

        $request->validate([
            'berat_badan' => 'required|numeric|max:500',
            'tinggi_badan' => 'required|numeric|min:32|max:250',
            'suhu_badan' => 'required|numeric|min:32|max:42',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
            'anjuran' => 'required|string',
            'obat' => 'required|string',
        ]);

        $report->update([
            'weight' => $request->berat_badan,
            'height'=> $request->tinggi_badan,
            'temperature' => $request->suhu_badan,
            'initial_complaint' => $request->keluhan,
            'diagnosis' => $request->diagnosa,
            'recommendations' => $request->anjuran,
            'medications' => $request->obat,
            'sick_note' => $request->surat_dokter == null ? '0' : '1' ,
        ]);

        $payment->update([
            'amount' => $biaya,
            'status' => $status,
        ]);
        
        return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate!'], 200);
        
    }

    public function showReportForm(Request $request) {
        $report = Report::where('reservation_id',$request->id)->first();
        if($report == null && Reservation::with(['patient','doctor'])->findOrFail($request->id) == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found',
                'data' => null
            ],404);
        }
        else if($report == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data report retrieved successfully',
                'data' => [
                    "report" => null,
                    "reservation" => Reservation::with(['patient','doctor'])->findOrFail($request->id),
                ] 
                ],200);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Data report retrieved successfully',
                'data' => [
                    "report" => Report::with(['reservation','reservation.patient','reservation.payment','reservation.doctor'])->where('reservation_id',$request->id)->first(),
                ]
            ], 200);
        }
    }
}
