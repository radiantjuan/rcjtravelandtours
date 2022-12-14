<?php
/**
 * Bookable Review
 * Handles showing the list of reviews for each bookables
 *
 * @author    Radiant Juan <radiantcjuan@gmail.com>
 * @copyright RCJWorks 2022
 */

namespace App\Http\Controllers;

use App\Bookable;
use App\Http\Resources\BookableReviewResource;
use Illuminate\Http\Request;

class BookableReviewController extends Controller {
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke($id, Request $request) {
        $bookable = Bookable::findOrFail($id);
        return BookableReviewResource::collection($bookable->reviews()->latest()->get());
    }
}
