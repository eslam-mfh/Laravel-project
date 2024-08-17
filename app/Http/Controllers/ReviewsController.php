<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Reviews;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $review = Reviews::all();
        return response()->json($review);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Reviews $reviews
     * @return \Illuminate\Http\Response
     */
    public function show(Reviews $reviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Reviews $reviews
     * @return \Illuminate\Http\Response
     */
    public function edit(Reviews $reviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Reviews $reviews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reviews $reviews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Reviews $reviews
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reviews $reviews)
    {
        //
    }

    public function writeReview(Request $request, $sessionId)
    {
        // التحقق من حالة الجلسة
        $session = Session::findOrFail($sessionId);
        $user = $request->user();

        if ($session->status == 2 && $session->user_id == $user->id) {
            // إنشاء التقييم وحفظه في جدول reviews
            $review = new Reviews();
            $review->user_id = $session->user_id ;
            $review->session_id = $session->id;
            $review->review = $request->input('review');
            $review->save();

            return response()->json('Review added successfully');
        } else {
            return response()->json(['message' => 'You are not authorized to write a review for this session'], 403);
        }
    }

    public function addReview(Request $request)
    {
        $user = $request->user();
        $review = new Reviews();
        $review->user_id = $user->id ;
        $review->review = $request->input('review');
        $review->type = 1;
        $review->save();

        return response()->json('Review added successfully');
    }
    public function approveReview($reviewId)
    {
        $review = Reviews::findOrFail($reviewId);
        $review->type = 2;
        $review->save();

        return response()->json(['message' => 'Review type changed to 2 successfully', 'review' => $review]);
    }

    public function getApprovedReviews()
    {
        $reviews = Reviews::where('type', 2)->select('id', 'review')->get();
        return response()->json($reviews);
    }

    public function getPendingReviews()
    {
        $reviews = Reviews::where('type', 1)->select('id', 'review')->get();
        return response()->json($reviews);
    }

    public function rate(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = new Rating();
        $rating->user_id = auth()->id();
        $rating->rating = $request->rating;
        $rating->save();

        return response()->json( 'Rating added successfully');
    }

    public function averageRating()
    {
        $average = Rating::avg('rating');

        return response()->json($average);
    }



}
