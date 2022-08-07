<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
