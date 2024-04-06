<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Review;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
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
