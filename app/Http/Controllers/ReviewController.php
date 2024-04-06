<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

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
            $reviewsQuery->where('rating',$rating);
        }

        $reviews = $reviewsQuery->paginate(10)->withQueryString();

        return view('admin.review_data',["reviews" => $reviews]);
    }

    public function destroy($id) {

        Review::where('id', $id)->delete();

        return redirect('/admin/data-review')->with('success', 'Data berhasil dihapus!');
    }
}
