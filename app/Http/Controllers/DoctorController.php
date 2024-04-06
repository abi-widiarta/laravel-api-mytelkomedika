<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Review;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function __construct()
    // {
    //     $this->middleware('auth:doctor');
    // }

    public function index()
    {   
        $doctors = Doctor::query();

        if (request('search')) {
            $doctors->where('name', 'like', '%' . request('search') . '%')->orWhere('specialization', 'like', '%' . request('search') . '%');
        }
        return view('admin.doctor_data',["doctors" => $doctors->paginate(10)->withQueryString()]);
    }

    public function dashboard(Request $request)
    {
        // dd($request->all());
        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/dokter/dashboard', [
                'poli' => $request->poli,
                'tanggal_reservasi' => $request->tanggal_reservasi,
            ]);

            $reservations = $response->json();


            return view('doctor.dashboard', ['reservations' => $reservations['data'],'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }

    public function showQueues(Request $request) {
        // dd($request->all());
        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/dokter/antrian-pemeriksaan', [
                'poli' => $request->poli,
                'tanggal_reservasi' => $request->tanggal_reservasi,
            ]);

            $reservation = $response->json();

            return view('doctor.queue',['reservations' => $reservation['data'],"user" => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }

    public function showReviews(Request $request) {
        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/dokter/data-review', [
                'rating' => $request->rating,
            ]);

            $reviews = $response->json();

            return view('doctor.review_data',["reviews" => $reviews['data'], "user" => $user]);
           
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.doctor_data_add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:doctors,email|max:100',
            'username' => 'required|string|unique:doctors,username|max:30',
            'password' => 'max:15|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'poli' => 'required',
            'status' => 'required',
            'no_str' => 'required|string|max:100',
            'no_hp' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $imageExtension = $request->file('image')->getClientOriginalExtension();
        $image_path = $request->file('image')->storeAs('img', $request->username . "." . $imageExtension,['disk' => 'public']);
        

        Doctor::create([
            "name" => $request->name,
            "email" => $request->email,
            "username" => $request->username,
            "password" => bcrypt($request->password),
            "specialization" => $request->poli,
            "status" => $request->status,
            "registration_number" => $request->no_str,
            "phone" => $request->no_hp,
            "gender" => $request->jenis_kelamin,
            "birthdate" => $request->tanggal_lahir,
            "address" => $request->alamat,
            "image" => "/uploads/" . $image_path,
        ]);

        return redirect('/admin/data-dokter')->with('success','Data berhasi dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($username)
    {
        try {
            $doctor = Doctor::where('username',$username)->firstOrFail();

            return view('admin.doctor_data_edit',["doctor" => $doctor]);
        } catch (ModelNotFoundException $exception) {
            return view("client.notFound",["exception" => $exception]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $username)
    {   
        $doctor = Doctor::where('username',$username)->firstOrFail();
        $initialPassword = $doctor->password;

        
        if($request->file('image') != null) {
            
            $imageExtension = $request->file('image')->getClientOriginalExtension();
            $image_path = $request->file('image')->storeAs('img', $request->username . "." . $imageExtension,['disk' => 'public']);

            $doctor->update([
                "name" => $request->name,
                "email" => $request->email,
                "username" => $request->username,
                "specialization" => $request->poli,
                "status" => $request->status,
                "registration_number" => $request->no_str,
                "phone" => $request->no_hp,
                "gender" => $request->jenis_kelamin,
                "birthdate" => $request->tanggal_lahir,
                "address" => $request->alamat,
                "password" => $request->password == null ? $initialPassword : bcrypt($request->password),
                "image" => "/uploads/" . $image_path,
            ]);
        } else {
            $doctor->update([
                "name" => $request->name,
                "email" => $request->email,
                "username" => $request->username,
                "specialization" => $request->poli,
                "status" => $request->status,
                "registration_number" => $request->no_str,
                "phone" => $request->no_hp,
                "gender" => $request->jenis_kelamin,
                "birthdate" => $request->tanggal_lahir,
                "address" => $request->alamat,
                "password" => $request->password == null ? $initialPassword : bcrypt($request->password),
            ]);
        }
        return redirect('/admin/data-dokter/edit/' . $request->username)->with('success','Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Doctor::where('id', $id)->delete();

        return redirect('/admin/data-dokter')->with('success', 'Data berhasil dihapus!');
    }
    
    public function authenticate(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    try {
        $response = Http::post('http://127.0.0.1:8000/api/login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $data = $response->json();

        // Simpan token dalam session
        session(['token' => $data['token']]);
        session(['user' => $data['user']]);

        // dd($data);

        // Redirect ke dashboard dengan menyertakan token dalam session
        return redirect('/dokter/dashboard');
    } catch (\Exception $e) {
        // Jika login gagal, arahkan kembali ke halaman login dengan pesan error
        throw ValidationException::withMessages([
            'username' => ['The provided credentials are incorrect.'],
        ]);
    }
}


    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'username' => 'required|min:3|max:15',
    //         'password' => 'required|max:15',
    //     ]);

        
    //     if (Auth::guard('doctor')->attempt($credentials)) {
            
    //         $request->session()->regenerate();  
            
    //         return redirect('/dokter/dashboard')->with('success','Login berhasil!');
    //     }

    //     return back()->withErrors([
    //         'username' => 'Username dan password salah',
    //     ])->onlyInput('username');
    // }

    public function logout(Request $request)
    {
        $token = $request->session()->get('token');
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/logout');
            
            // Periksa apakah respons sukses
            if ($response->successful()) {
                // Logout berhasil
                $request->session()->forget('token');
                $request->session()->forget('user');
                return redirect('/dokter/login')->with('success', 'Anda telah berhasil logout');
            } else {
                // Tangani jika logout gagal
                return redirect('/')->with('error', 'Logout gagal: ' . $response->body());
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi kesalahan dalam permintaan HTTP
            return redirect('/')->with('error', 'Terjadi kesalahan dalam melakukan logout: ' . $e->getMessage());
        }
    }
}
