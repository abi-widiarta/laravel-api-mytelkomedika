<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

class ReviewController extends Controller
{
    public function index(Request $request) {
        try {
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/admin/data-review',[
                'specialization' => $request->poli,
                'rating' => $request->rating

            ]);

            $data = $response->json();
            $objectData = json_decode(json_encode($data));

            return view('admin.review_data',['reviews' => $objectData->data]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve data.']);
        }      
    }

    public function destroy($id) {

        Review::where('id', $id)->delete();

        return redirect('/admin/data-review')->with('success', 'Data berhasil dihapus!');
    }
}
