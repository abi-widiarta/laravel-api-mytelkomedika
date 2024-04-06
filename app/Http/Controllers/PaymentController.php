<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

class PaymentController extends Controller
{
    public function index() {
        return view('admin.payment',['payments' => Payment::where('amount','!=','0')->get()]);
    }

    public function completePayment($id) {
        $payment = Payment::find($id);
        $payment->update([
            'status' => 1,
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}
