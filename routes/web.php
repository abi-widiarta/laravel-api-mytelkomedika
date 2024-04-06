<?php

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Report;
use App\Models\Review;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\ScheduleTime;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DoctorScheduleController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// GUEST
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('landingPage');
    });
    
    Route::get('/login', function () {
        return view('auth.client_login');
    })->name('login');
    
    Route::post('/login', [PatientController::class, 'authenticate']);

    Route::get('/contact', function () {
        return "contact page";
    });
    
    Route::get('/register', function () {
        return view('auth.client_register');
    });
    
    Route::post('/register', [PatientController::class, 'store']);
    
    Route::get('/admin/register', function () {
        return view('auth.admin_register');
    });

    Route::post('/admin/register', [RegisterController::class, 'storeAdmin']);
    
    Route::get('/admin/login', function () {
        return view('auth.admin_login');
    });

    Route::get('/dokter/login', function () {
        return view('auth.doctor_login');
    });
    
    Route::post('/admin/login', [AdminController::class, 'authenticate']);

    Route::post('/dokter/login', [DoctorController::class, 'authenticate']);
});

// PASIEN
Route::middleware(['auth','verified'])->group(function () {

    Route::get('/dashboard', [PatientController::class, 'dashboard']);

    Route::get('/lakukan-reservasi', [PatientController::class, 'showDoctors']);

    Route::get('/lakukan-reservasi/detail/{username}', [PatientController::class, 'showDoctorDetail']);

    Route::get('/reservasi-saya', [PatientController::class, 'showReservations']);
    
    Route::get('/riwayat-pemeriksaan', [PatientController::class, 'showResults']);

    Route::get('/riwayat-pemeriksaan/detail/{id}', [PatientController::class, 'showResultDetail']);

    Route::get('/riwayat-pemeriksaan/detail/pdf/{id}',[PatientController::class, 'showResultDetailPDF'] );

    Route::post('/lakukan-reservasi/detail/{id}',  [ReservationController::class, 'store']);
    
    Route::post('/reservasi-saya/cancel/{id}',  [ReservationController::class, 'cancel']);

    Route::post('/riwayat-pemeriksaan/detail/review/{id}', [PatientController::class, 'makeReview']);
    
    Route::post('/logout', [PatientController::class, 'logout']);

    Route::get('/profile', [PatientController::class, 'profileEdit']);

    Route::post('/profile/edit/{id}',  [PatientController::class, 'profileUpdate']);
});

// ADMIN
// Route::middleware('auth:admin')->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

//     Route::post('/admin/logout', [AdminController::class, 'logout']);
    
//     Route::get('/admin/data-pasien',[PatientController::class, 'index']); 
    
//     Route::get('/admin/data-pasien/create',[PatientController::class, 'create']); 
    
//     Route::post('/admin/data-pasien/store',[PatientController::class, 'store']); 
    
//     Route::post('/admin/data-pasien/delete/{id}', [PatientController::class, 'destroy']);
    
//     Route::get('/admin/data-pasien/edit/{username}', [PatientController::class, 'edit']);
    
//     Route::post('/admin/data-pasien/update/{id}', [PatientController::class, 'update']);
    
//     Route::get('/admin/data-dokter',[DoctorController::class, 'index']);
    
//     Route::get('/admin/data-dokter/create',[DoctorController::class, 'create']);
    
//     Route::post('/admin/data-dokter/store',[DoctorController::class, 'store']);
    
//     Route::get('/admin/data-dokter/edit/{username}',[DoctorController::class, 'edit']);
    
//     Route::post('/admin/data-dokter/update/{username}', [DoctorController::class, 'update']);
    
//     Route::post('/admin/data-doctor/delete/{id}', [DoctorController::class, 'destroy']);
    
//     Route::get('/admin/jadwal-dokter', [DoctorScheduleController::class, 'index']);

//     Route::get('/admin/jadwal-dokter/create', [DoctorScheduleController::class, 'create']);

//     Route::post('/admin/jadwal-dokter/store',[DoctorScheduleController::class, 'store']);

//     Route::get('/admin/jadwal-dokter/edit/{id}', [DoctorScheduleController::class, 'edit']);

//     Route::post('/admin/jadwal-dokter/update/{id}', [DoctorScheduleController::class, 'update']);

//     Route::post('/admin/jadwal-dokter/delete/{id}',[DoctorScheduleController::class, 'destroy'] );
    
//     Route::get('/admin/antrian-pemeriksaan', [ReservationController::class, 'index']);

//     Route::post('/admin/antrian-pemeriksaan/complete/{id}', [ReservationController::class, 'completeReservation']);

//     Route::get('/admin/antrian-pemeriksaan/hasil-pemeriksaan/{id}', [ReservationController::class, 'showReportForm']);

//     Route::post('/admin/antrian-pemeriksaan/hasil-pemeriksaan/{id}',  [ReportController::class, 'store']);

//     Route::post('/admin/antrian-pemeriksaan/hasil-pemeriksaan/update/{id}',[ReportController::class, 'update']);
    
//     Route::get('/admin/pembayaran', [PaymentController::class, 'index']);

//     Route::post('/admin/pembayaran/complete/{id}', [PaymentController::class, 'completePayment']);

//     Route::get('/admin/data-admin', [AdminController::class, 'index']);

//     Route::get('/admin/data-admin/create', [AdminController::class, 'create']);

//     Route::post('/admin/data-admin/store', [AdminController::class, 'store']);

//     Route::get('/admin/data-admin/edit/{id}', [AdminController::class, 'edit']);

//     Route::post('/admin/data-admin/edit/{id}', [AdminController::class, 'update']);

//     Route::post('/admin/data-admin/delete/{id}', [AdminController::class, 'destroy']);

//     Route::get('/admin/data-review', [ReviewController::class, 'index']);

//     Route::post('/admin/data-review/delete/{id}', [ReviewController::class, 'destroy'] );
// });

// Dokter
Route::get('/dokter/dashboard', [DoctorController::class, 'dashboard']);

Route::get('/dokter/antrian-pemeriksaan', [DoctorController::class, 'showQueues']);

Route::get('/dokter/data-review',[DoctorController::class, 'showReviews'] );

Route::post('/doctor/logout', [DoctorController::class, 'logout']);
Route::middleware('auth:doctor')->group(function () {
});

// Route::get('/doctors', function () {
//   $response = Http::withToken('7|TIsPVm0U87PXHpumFVSZexaEPQBHw37EZiwu0Qqu6d6c7dd2')->get('http://127.0.0.1:8000/api/dokter/data-review');

//   dd($response->json());
// });

// Email Verification

// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
    
//     return redirect('/dashboard');
// })->middleware(['auth', 'signed'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();

//     return back()->with('message', 'New verification has been link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
