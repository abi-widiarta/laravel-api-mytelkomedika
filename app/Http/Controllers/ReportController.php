<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function store(Request $request) {
        try {
            // Mengambil token dari session atau tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Panggil API dengan token bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/admin/antrian-pemeriksaan/hasil-pemeriksaan', [
                'id' => $request->id,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'suhu_badan' => $request->suhu_badan,
                'keluhan' => $request->keluhan,
                'diagnosa' => $request->diagnosa,
                'anjuran' => $request->anjuran,
                'obat' => $request->obat,
                'biaya' => $request->biaya,
                'surat_dokter' => $request->surat_dokter
            ]);

            if ($response->successful() && $response['status'] === 'success') {
                return redirect()->back()->withToastSuccess('Laporan berhasil dibuat!');
            } else {
                return redirect()->back()->withErrors(['error' => '']);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return redirect()->back()->withErrors(['error' => 'Gagal membuat reservasi.']);
        }
    }

    public function update(Request $request) {
        try {
            // Mengambil token dari session atau tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Panggil API dengan token bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/admin/antrian-pemeriksaan/hasil-pemeriksaan/update', [
                'id' => $request->id,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'suhu_badan' => $request->suhu_badan,
                'keluhan' => $request->keluhan,
                'diagnosa' => $request->diagnosa,
                'anjuran' => $request->anjuran,
                'obat' => $request->obat,
                'biaya' => $request->biaya,
                'surat_dokter' => $request->surat_dokter
            ]);

            if ($response->successful() && $response['status'] === 'success') {
                return redirect()->back()->withToastSuccess('Laporan berhasil diupdate!');
            } else {
                return redirect()->back()->withErrors(['error' => $response['message']]);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return redirect()->back()->withErrors(['error' => 'Gagal update laporan.']);
        }
    }
}
