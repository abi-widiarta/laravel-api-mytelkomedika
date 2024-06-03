<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;


class PaymentController extends Controller
{
    public function index(Request $request) {
        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/admin/pembayaran');

            $data = $response->json();
            $objectData = json_decode(json_encode($data));
            
            return view('admin.payment',['payments' => $objectData->data]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }      

        return view('admin.payment',['payments' => Payment::where('amount','!=','0')->get()]);
    }

    public function completePayment(Request $request) {
        try {
            // Mengambil token dari session atau tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Panggil API dengan token bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/admin/pembayaran/complete', [
                'id' => $request->id,
            ]);

            if ($response->successful() && $response['status'] === 'success') {
                // Jika berhasil, kembalikan ke halaman sebelumnya dengan pesan sukses
                return redirect()->back()->withToastSuccess('Pembayaran berhasil diselesaikan!');
            } else {
                return redirect()->back()->withErrors(['error' => $response['message']]);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return redirect()->back()->withErrors(['error' => 'Gagal menyelesaikan pembayaran']);
        }
    }
}
