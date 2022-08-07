<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model {

    protected $fillable = ['from', 'to'];

    /**
     * Relationship table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bookable() {
        return $this->belongsTo(Bookable::class);
    }

    public function review() {
        return $this->hasOne(Review::class);
    }

    public function scopeBetweenDates(\Illuminate\Database\Eloquent\Builder $query, $from, $to) {
        return $query->where('to', '>=', $from)->where('from', '<=', $to);
    }

    /**
     * @param string $reviewKey
     * @return \App\Booking|null
     */
    public static function findByReviewKey(string $reviewKey): ?Booking {
        return static::where('review_key', $reviewKey)->with('bookable')->get()->first();
    }

    protected static function boot() {
        parent::boot();
        static::creating(function($booking) {
            $booking->review_key = Str::uuid();
        });
    }
}
