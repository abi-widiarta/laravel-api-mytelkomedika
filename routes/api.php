<?php

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\DoctorScheduleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/dokter/login', function (Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $user = Doctor::where('username', $request->username)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken("token_login")->plainTextToken;

    // Mengembalikan token sebagai respons
    return response()->json([
        'token' => $token,
        'user' => $user // Jika Anda ingin mengembalikan informasi pengguna lainnya juga
    ]);
});

Route::post('logout', function (Request $request) {

    $request->user()->currentAccessToken()->delete();

})->middleware(['auth:sanctum']);

Route::get('/doctors', [PatientController::class, 'showDoctors']);


// PATIENT
Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $user = Patient::where('username', $request->username)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken("token_login")->plainTextToken;

    // Mengembalikan token sebagai respons
    return response()->json([
        'token' => $token,
        'user' => $user // Jika Anda ingin mengembalikan informasi pengguna lainnya juga
    ]);
});

Route::post('/register', [PatientController::class, 'storePatient']);

Route::get('/dashboard', [PatientController::class, 'dashboard'])->middleware(['auth:sanctum']);

Route::get('/lakukan-reservasi', [PatientController::class, 'showDoctors'])->middleware(['auth:sanctum']);

Route::get('/lakukan-reservasi/detail', [PatientController::class, 'showDoctorDetail'])->middleware(['auth:sanctum']);

Route::get('/reservasi-saya', [PatientController::class, 'showReservations'])->middleware(['auth:sanctum']);

Route::get('/riwayat-pemeriksaan', [PatientController::class, 'showResults'])->middleware(['auth:sanctum']);

Route::get('/riwayat-pemeriksaan/detail', [PatientController::class, 'showResultDetail'])->middleware(['auth:sanctum']);

Route::post('/lakukan-reservasi/detail',  [ReservationController::class, 'store'])->middleware(['auth:sanctum']);

Route::post('/reservasi-saya/cancel',  [ReservationController::class, 'cancel'])->middleware(['auth:sanctum']);

Route::post('/review', [PatientController::class, 'makeReview']);

Route::post('/logout', [PatientController::class, 'logout'])->middleware(['auth:sanctum']);

// DOCTOR

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dokter/dashboard', [DoctorController::class, 'dashboard']);
    
    Route::get('/dokter/antrian-pemeriksaan', [DoctorController::class, 'showQueues']);
    
    Route::get('/dokter/data-review', [DoctorController::class, 'showReviews']);
    
    Route::post('/dokter/logout', [DoctorController::class, 'logout']);
});

// ADMIN

Route::post('/admin/login', function (Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $user = Admin::where('username', $request->username)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken("token_login")->plainTextToken;

    // Mengembalikan token sebagai respons
    return response()->json([
        'token' => $token,
        'user' => $user // Jika Anda ingin mengembalikan informasi pengguna lainnya juga
    ]);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/admin/antrian-pemeriksaan/hasil-pemeriksaan',  [ReportController::class, 'showReportForm']);
    
    Route::post('/admin/antrian-pemeriksaan/hasil-pemeriksaan',  [ReportController::class, 'store']);
    
    Route::post('/admin/antrian-pemeriksaan/hasil-pemeriksaan/update',  [ReportController::class, 'update']);

    Route::post('/admin/logout', [AdminController::class, 'logout'])->middleware(['auth:sanctum']);
    
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth:sanctum']);
    
    Route::get('/admin/data-pasien',[PatientController::class, 'index']); 
    
    Route::get('/admin/data-dokter',[DoctorController::class, 'index']);
    
    Route::get('/admin/jadwal-dokter', [DoctorScheduleController::class, 'index']);

    Route::get('/admin/antrian-pemeriksaan', [ReservationController::class, 'index']);

    Route::post('/admin/antrian-pemeriksaan/complete', [ReservationController::class, 'completeReservation']);

    Route::get('/admin/pembayaran', [PaymentController::class, 'index']);

    Route::post('/admin/pembayaran/complete', [PaymentController::class, 'completePayment']);

    Route::get('/admin/data-admin', [AdminController::class, 'index']);

    Route::get('/admin/data-review', [ReviewController::class, 'index']);
});
