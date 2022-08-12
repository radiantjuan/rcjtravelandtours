<?php

namespace App\Http\Controllers;

use App\Address;
use App\Bookable;
use App\Booking;
use Illuminate\Http\Request;

class CheckoutController extends Controller {
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection
     */
    public function __invoke(Request $request) {
        //
        $data = $request->validate([
            'bookings' => 'required|array|min:1',
            'bookings.*.bookable_id' => 'required|exit:bookable,id', //you can use model for validation as well
            'bookings.*.from' => 'required|date|after_or_equal:today',
            'bookings.*.to' => 'required|date|after_or_equal:from',
//you can also do this validation
//            'bookings.*' => ['required', function($attribute, $value, $fail) {
//                $bookable = Bookable::findOrFail($value['bookable_id']);
//                if (!$bookable->availableFor($value['from'], $value['to'])) {
//                    $fail("The object is not available in given dates!");
//                }
//            }],
            'customer.first_name' => 'required|min:2',
            'customer.last_name' => 'required|min:2',
            'customer.street' => 'required|min:2',
            'customer.city' => 'required|min:2',
            'customer.email' => 'required|email',
            'customer.country' => 'required|min:2',
            'customer.state' => 'required|min:2',
            'customer.zip' => 'required|min:2',
        ]);

        $data = array_merge($data, $request->validate([
            'bookings.*' => ['required', function ($attribute, $value, $fail) {
                $bookable = Bookable::findOrFail($value['bookable_id']);
                if (!$bookable->availableFor($value['from'], $value['to'])) {
                    $fail("The object is not available in given dates!");
                }
            }],
        ]));

        $bookingsData = $data['bookings'];
        $addressData = $data['customer'];

        $bookings = collect($bookingsData)->map(function ($bookingData) use ($addressData) {
            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
            $booking->price = 200;
            $booking->bookable_id = $bookingData['bookable_id'];

            $booking->address()->associate(Address::create($addressData));

            $booking->save();

            return $booking;
        });

        return $bookings;
    }
}
