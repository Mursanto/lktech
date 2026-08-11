<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoogleReviewController extends Controller
{
    public function index(Request $request)
    {
        $totalReviews = \App\Models\GoogleReview::count();
        $avgRating = \App\Models\GoogleReview::avg('star_rating') ?? 0;
        $displayedReviews = \App\Models\GoogleReview::where('is_featured', true)->count();
        $unrepliedReviews = \App\Models\GoogleReview::whereNull('review_reply')->orWhere('review_reply', '')->count();

        $query = \App\Models\GoogleReview::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('reviewer_name', 'like', "%{$search}%")
                  ->orWhere('review_comment', 'like', "%{$search}%");
        }

        $reviews = $query->orderBy('review_created_at', 'desc')->paginate(10);

        return view('admin.google-reviews.index', compact(
            'reviews', 'totalReviews', 'avgRating', 'displayedReviews', 'unrepliedReviews'
        ));
    }

    public function toggleFeatured(\App\Models\GoogleReview $googleReview)
    {
        $googleReview->is_featured = !$googleReview->is_featured;
        $googleReview->save();

        return response()->json([
            'success' => true,
            'is_featured' => $googleReview->is_featured,
            'message' => 'Status tampilan ulasan berhasil diubah.'
        ]);
    }

    public function reply(Request $request, \App\Models\GoogleReview $googleReview)
    {
        $request->validate([
            'reply' => 'required|string|max:1000'
        ]);

        $googleReview->review_reply = $request->reply;
        $googleReview->save();

        // Di sini nantinya bisa ditambahkan logic untuk mengirim balasan ke Google API.

        return back()->with('success', 'Balasan ulasan berhasil disimpan.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reviewer_name' => 'required|string|max:255',
            'star_rating' => 'required|integer|min:1|max:5',
            'review_comment' => 'nullable|string',
            'is_featured' => 'boolean',
            'review_time_text' => 'nullable|string|max:100'
        ]);

        $googleReviewId = 'manual_' . uniqid();

        \App\Models\GoogleReview::create([
            'google_review_id' => $googleReviewId,
            'reviewer_name' => $request->reviewer_name,
            'star_rating' => $request->star_rating,
            'review_comment' => $request->review_comment,
            'is_featured' => $request->has('is_featured'),
            'review_created_at' => \Carbon\Carbon::now(),
            'review_time_text' => $request->review_time_text,
            'reviewer_photo_url' => null // Set to null so the frontend uses the initials feature
        ]);

        return back()->with('success', 'Ulasan manual berhasil ditambahkan.');
    }

    public function destroy(\App\Models\GoogleReview $googleReview)
    {
        $googleReview->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
