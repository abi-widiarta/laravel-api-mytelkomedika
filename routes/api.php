<?php

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\DoctorResource;
use App\Http\Controllers\Api\DoctorController;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\PatientController;

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

Route::get('doctors', function () {
    $doctors = Doctor::all();
    return DoctorResource::collection($doctors);
})->middleware(['auth:sanctum']);

Route::get('doctors/{id}', function ($id) {
    $doctor = Doctor::findOrFail($id);
    return response()->json($doctor);
});

Route::post('login', function (Request $request) {
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

// PATIENT

Route::get('/doctors', [PatientController::class, 'showDoctors']);

// DOCTOR

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dokter/dashboard', [DoctorController::class, 'dashboard']);
    
    Route::get('/dokter/antrian-pemeriksaan', [DoctorController::class, 'showQueues']);
    
    Route::get('/dokter/data-review', [DoctorController::class, 'showReviews']);
    
    Route::post('/dokter/logout', [DoctorController::class, 'logout']);
});