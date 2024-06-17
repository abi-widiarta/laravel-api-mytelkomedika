<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Events\Registered;


class RegisterController extends Controller
{
    public function index() {
        return view('auth.client_register');
    }


    public function storePatient(Request $request)
    {
        try {
            // Memanggil API untuk registrasi
            $response = Http::post('http://127.0.0.1:8000/api/register', [
                'student_id' => $request->input('student_id'),
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]);

            // Cek apakah registrasi berhasil
            if ($response->successful()) {
                return redirect('/login')->with('status', 'Registrasi berhasil. Silakan login.');
            } else {
                $errors = $response->json()['errors'] ?? ['api_error' => 'Registrasi gagal. Silakan coba lagi.'];
                return redirect()->back()->withErrors($errors)->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['api_error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

}
