<?php

namespace App\Http\Controllers;

use App\Bookable;
use Illuminate\Http\Request;

class BookingController extends Controller {
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $bookable_id) {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:now',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from'
        ]);

        $bookable = Bookable::findOrFail($bookable_id);
        return !$bookable->availableFor($data['from'], $data['to']) ? response()->json([]): response()->json([], 404);
    }
}
