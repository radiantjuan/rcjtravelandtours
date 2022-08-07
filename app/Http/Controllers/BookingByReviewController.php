<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Http\Resources\BookingByReviewBookableShowResource;
use App\Http\Resources\BookingByReviewShowResource;
use Illuminate\Http\Request;

class BookingByReviewController extends Controller {
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    public function __invoke($review_key, Request $request) {
        $booking = Booking::findByReviewKey($review_key);
        return $booking ? new BookingByReviewShowResource(Booking::findByReviewKey($review_key)) ?? abort(404) : abort(404);
    }
}
