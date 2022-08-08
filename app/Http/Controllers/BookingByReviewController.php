<?php
/**
 * Booking By review Controller
 * Handles request to check if there is no existing review
 *
 * @author    Radiant Juan <radiantcjuan@gmail.com>
 * @copyright RCJWorks 2022
 */

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
     * @return \App\Http\Resources\BookingByReviewShowResource|boolean
     */
    public function __invoke($review_key, Request $request) {
        $booking = Booking::findByReviewKey($review_key);
        $return = false;
        if ($booking) {
            $return = new BookingByReviewShowResource(Booking::findByReviewKey($review_key));
        } else {
            abort(404);
        }
        return $return;
    }
}
