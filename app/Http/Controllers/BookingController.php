<?php
/**
 * Booking Controller
 * This handles booking action, where the system will save the customer's booking info
 *
 * @author    Radiant Juan <radiantcjuan@gmail.com>
 * @copyright RCJWorks 2022
 */
namespace App\Http\Controllers;

use App\Bookable;
use Illuminate\Http\Request;

class BookingController extends Controller {
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, $bookable_id) {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:today',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from'
        ]);

        $bookable = Bookable::findOrFail($bookable_id);
        return $bookable->availableFor($data['from'], $data['to']) ? response()->json([]) : abort(404);
    }
}
