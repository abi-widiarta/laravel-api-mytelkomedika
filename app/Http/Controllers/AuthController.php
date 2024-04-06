<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|min:3|max:15',
            'password' => 'required|max:15',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();  
            return redirect('/dashboard')->with('success','Login berhasil!');
        }

        return back()->withErrors([
            'login_error' => 'Username dan password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function store(Request $request) {
        $validatedData = $this->validatePatient($request);

        if (!$this->isValidEmailFormat($validatedData['email'])) {
            return back()->withErrors(['email_format' => 'Please use an Telkom University student email'])->withInput();
        }

        // buat request ke api dengan parameter nim dan ambil responnya
        $apiResponse = $this->getApiData($validatedData['student_id']);
    
        // cek respon api
        if ($apiResponse->successful()) {
            $apiData = $apiResponse->json();
            $mahasiswaText = $apiData['mahasiswa'][0]['text'];
            $namaMahasiswa = Str::between(Str::before($mahasiswaText, '('), '"', '"');
    
            // cek apakah ada nim dan universitas telkom di response
            if ($this->isValidNim($mahasiswaText,$validatedData['student_id'])) {
                
                // cek nama yang dimasukkan di input sama atau tidak dari respon api
                if($namaMahasiswa !== strtoupper($validatedData['name'])) {
                    return back()->withErrors(['name_validation' => 'NIM dan nama tidak sesuai, harap masukan nama dan nim yang benar'])->withInput();
                };

                // jika valid, encrypt password dan buat records baru
                $this->createPatient($validatedData);

                return redirect('/email/verify');
            } else {
                return back()->withErrors(['student_id_validation' => 'NIM tidak teregistrasi di Telkom University'])->withInput();
            }  
        } else {
            return back()->withErrors(['api_error' => 'System Is Busy, please try again later'])->withInput();
        }
    }

    private function validatePatient(Request $request)
    {
        return $request->validate([
            'student_id' => 'required|size:10|unique:patients',
            'name' => 'required|max:50',
            'username' => 'required|min:3|max:15|unique:patients',
            'email' => 'required|max:50|unique:patients|email:dns,rfc',
            'password' => 'required|max:15|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);
    }

    private function isValidEmailFormat($email)
    {
        return Str::endsWith($email, '@student.telkomuniversity.ac.id');
    }

    private function isValidNim($textResponse,$nim)
    {
        return strpos($textResponse, $nim) !== false && strpos($textResponse, 'UNIVERSITAS TELKOM') !== false;
    }

    private function getApiData($studentId)
    {
        $apiEndpoint = "http://127.0.0.1:5000/search_mahasiswa?student_id={$studentId}";
        return Http::get($apiEndpoint);
    }

    private function createPatient($validatedData)
    {
        $validatedData['password'] = bcrypt($validatedData['password']);
        $patient = Patient::create($validatedData);
        event(new Registered($patient));
        Auth::login($patient);
    }
}
