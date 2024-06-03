<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index() {
        $payments = Payment::with(['reservation','reservation.patient','reservation.doctor'])->where('amount','!=','0')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Payments data retrieved successfully',
            'data' => $payments
        ]);
    }

    public function completePayment(Request $request) {
        $payment = Payment::find($request->id);

        if ($payment) {
            $payment->update([
                'status' => 1,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran berhasil dikonfirmasi!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }
    }
}
