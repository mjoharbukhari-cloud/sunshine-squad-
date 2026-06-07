<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new review (for Product OR Deal)
     */
    public function store(Request $request)
    {
        // 1. Validate the request
        $request->validate([
            'reviewable_id' => 'required|integer',
            'reviewable_type' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // 2. Create the review
        Review::create([
            'user_id' => Auth::id(),
            'reviewable_id' => $request->reviewable_id,
            'reviewable_type' => $request->reviewable_type,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // 3. Return to the previous page
        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}