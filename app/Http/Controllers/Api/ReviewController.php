<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index(Request $request) {
        $reviewsQuery = Review::query();

        if ($request->has('poli')) {
            $poli = $request->poli;
            $reviewsQuery->whereHas('doctor', function ($query) use ($poli) {
                $query->where('specialization', $poli);
            });
        }

        if ($request->has('rating')) {
            $rating = $request->rating;
            $reviewsQuery->where('rating', $rating);
        }

        $reviews = $reviewsQuery->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Reviews data retrieved successfully',
            'data' => $reviews
        ]);
    }

    public function destroy(Request $request) {
        $review = Review::find($request->id);

        if ($review) {
            $review->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data review tidak ditemukan'
            ], 404);
        }
    }
}
