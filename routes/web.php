<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\RegisterController;


// PASIEN
Route::get('/', function () {
    return view('auth.client_login');
});

Route::get('/login', function () {
    return view('auth.client_login');
})->name('login');

Route::get('/register', function () {
    return view('auth.client_register');
});

Route::post('/register', [RegisterController::class, 'storePatient']);

Route::post('/login', [PatientController::class, 'authenticate']);

Route::get('/dashboard', [PatientController::class, 'dashboard']);

Route::get('/lakukan-reservasi', [PatientController::class, 'showDoctors']);

Route::get('/lakukan-reservasi/detail', [PatientController::class, 'showDoctorDetail']);

Route::get('/reservasi-saya', [PatientController::class, 'showReservations']);

Route::get('/riwayat-pemeriksaan', [PatientController::class, 'showResults']);

Route::get('/riwayat-pemeriksaan/detail', [PatientController::class, 'showResultDetail']);

Route::post('/lakukan-reservasi/detail',  [ReservationController::class, 'store']);

Route::post('/reservasi-saya/cancel',  [ReservationController::class, 'cancel']);

Route::post('/riwayat-pemeriksaan/detail/review', [PatientController::class, 'makeReview']);

Route::get('/riwayat-pemeriksaan/detail/pdf/{id}',[PatientController::class, 'showResultDetailPDF'] );


// Admin
Route::get('/admin/login', function () {
    return view('auth.admin_login');
});

Route::post('/admin/login', [AdminController::class, 'authenticate']);

Route::post('/logout', [PatientController::class, 'logout']);

Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

Route::get('/admin/data-pasien',[PatientController::class, 'index']); 

Route::get('/admin/data-dokter',[DoctorController::class, 'index']);

Route::get('/admin/jadwal-dokter', [DoctorScheduleController::class, 'index']);

Route::get('/admin/antrian-pemeriksaan', [ReservationController::class, 'index']);

Route::post('/admin/antrian-pemeriksaan/complete', [ReservationController::class, 'completeReservation']);

Route::get('/admin/antrian-pemeriksaan/hasil-pemeriksaan', [ReservationController::class, 'showReportForm']);

Route::post('/admin/antrian-pemeriksaan/hasil-pemeriksaan/update',[ReportController::class, 'update']);

Route::post('/admin/antrian-pemeriksaan/hasil-pemeriksaan',  [ReportController::class, 'store']);

Route::get('/admin/pembayaran', [PaymentController::class, 'index']);

Route::post('/admin/pembayaran/complete', [PaymentController::class, 'completePayment']);

Route::get('/admin/data-admin', [AdminController::class, 'index']);

Route::get('/admin/data-review', [ReviewController::class, 'index']);

Route::post('/admin/data-review/delete', [ReviewController::class, 'destroy']);

Route::post('/admin/logout', [AdminController::class, 'logout']);

// Dokter
Route::get('/dokter/login', function () {
    return view('auth.doctor_login');
});

Route::post('/dokter/login', [DoctorController::class, 'authenticate']);

Route::get('/dokter/dashboard', [DoctorController::class, 'dashboard']);

Route::get('/dokter/antrian-pemeriksaan', [DoctorController::class, 'showQueues']);

Route::get('/dokter/data-review',[DoctorController::class, 'showReviews'] );

Route::post('/dokter/logout', [DoctorController::class, 'logout']);
