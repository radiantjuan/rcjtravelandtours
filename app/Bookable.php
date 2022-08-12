<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Bookable extends Model {
    /**
     * Bookable relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function availableFor($from, $to) {
        return 0 === $this->bookings()->betweenDates($from, $to)->count();
    }

    public function priceFor($from, $to) {
        $days = (new Carbon($from))->diffInDays(new Carbon($to));
        $price = $days * $this->price;
        return [
            'total' => $price,
            'breakdown' => [
                $this->price => $days
            ]
        ];
    }
}
