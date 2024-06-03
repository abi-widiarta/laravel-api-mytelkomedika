<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Review;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function index(Request $request) {
        $doctors = Doctor::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $doctors->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('specialization', 'like', '%' . $searchTerm . '%');
            });
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Doctors data retrieved successfully',
            'data' => $doctors->get()
        ]);
    }

    public function store(Request $request) {
        // return $request->image;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:doctors,email|max:100',
            'username' => 'required|string|unique:doctors,username|max:30',
            'password' => 'max:15|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'poli' => 'required',
            'status' => 'required',
            'no_str' => 'required|unique:doctors,registration_number|string|max:100',
            'no_hp' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }
    
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
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data dokter berhasil dibuat!',
        ], 200);
    }

    public function edit(Request $request) {
        $doctor = Doctor::where('username', $request->username)->firstOrFail();

        return response()->json([
            'status' => 'success',
            'message' => 'Data dokter edit retrieved successfully',
            'data' => $doctor
        ]);
    }

    public function update(Request $request) {
        $doctor = Doctor::where('username', $request->current_username)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id . '|max:100',
            'username' => 'required|string|unique:doctors,username,' . $doctor->id . '|max:30',
            'poli' => 'required',
            'status' => 'required',
            'no_str' => 'required|string|max:100',
            'no_hp' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:100',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }
    
        $initialPassword = $doctor->password;
        $password = $request->password == null ? $initialPassword : bcrypt($request->password);
        

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
            "password" => $password,
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data dokter berhasil diupdate!',
        ], 200);
        
    }

    public function destroy(Request $request) {
        $doctor = Doctor::find($request->id);

        if ($doctor) {
            $doctor->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data dokter tidak ditemukan'
            ], 404);
        }
    }

    public function dashboard(Request $request) {
        $reservation = Reservation::with(['doctor','patient'])->whereHas('doctor', function ($subquery) use ($request) {
            $subquery->where('specialization', $request->poli);
            })
            ->when($request->tanggal_reservasi, function ($query) use ($request) {
                $originalDate = $request->tanggal_reservasi;
                $carbonDate = Carbon::createFromFormat('m/d/Y', $originalDate);
                $formattedDate = $carbonDate->format('Y-m-d');
                $query->where('date', $formattedDate);
            })
            ->where('status', '!=', 'canceled')->get();
            // ->paginate(10);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Dashboard data retrieved successfully',
            'data' => $reservation
        ],200);
    }
    
    public function showQueues(Request $request) {
        // $request['tanggal_reservasi'] = "12/22/2023";

        $reservation = Reservation::with(['doctor','patient'])->whereHas('doctor', function ($subquery) use ($request) {
            $subquery->where('specialization', $request->poli);
            })
            ->when($request->tanggal_reservasi, function ($query) use ($request) {
                $originalDate = $request->tanggal_reservasi;
                $carbonDate = Carbon::createFromFormat('m/d/Y', $originalDate);
                $formattedDate = $carbonDate->format('Y-m-d');
                $query->where('date', $formattedDate);
            })
            ->where('status', '!=', 'canceled')->get();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Queue data retrieved successfully',
            'data' => $reservation
        ],200);
    }
    
    public function showReviews(Request $request) {
        $reviewsQuery = Review::with(['doctor'])->whereHas('doctor', function ($query) {
            $query->where('id', Auth::user()->id);
        });
    
        if ($request->has('rating')) {
            $rating = $request->rating;
            $reviewsQuery->where('rating',$rating);
        }
    
        $reviews = $reviewsQuery->get();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Review data retrieved successfully',
            'data' => $reviews
        ],200);
    }

    public function logout(Request $request) {
        // Memeriksa apakah pengguna telah terautentikasi
        if ($request->user()) {
            // Menghapus token akses saat ini yang diasosiasikan dengan pengguna
            $request->user()->currentAccessToken()->delete();
    
            // Mengembalikan respons berhasil
            return response()->json(['message' => 'Logout berhasil'], 200);
        }
    
        // Jika pengguna tidak terautentikasi, kembalikan respons dengan pesan error
        return response()->json(['message' => 'Tidak ada pengguna terautentikasi'], 401);
    }
}
