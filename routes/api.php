<?php

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\DoctorResource;
use Illuminate\Validation\ValidationException;

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

    return $user->createToken("token_login")->plainTextToken;
});

Route::post('logout', function (Request $request) {

    $request->user()->currentAccessToken()->delete();

})->middleware(['auth:sanctum']);