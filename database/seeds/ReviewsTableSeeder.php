<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \App\Bookable::all()->each(function ($bookable) {
            $reviews = factory(\App\Review::class, random_int(5, 30))->make();
            $bookable->reviews()->saveMany($reviews);
        });
        //
    }
}
