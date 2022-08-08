<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('booklist', 'BookableController')->only(['index', 'show']);
Route::get('bookable/{bookable_id}/availability', 'BookingController')->name('bookable.availability.show');
Route::get('bookable/{bookable_id}/reviews','BookableReviewController')->name('bookable.review.index');
Route::get('bookable/{bookable_id}/price', 'BookablePriceController')->name('bookable.price.show');
Route::apiResource('reviews', 'ReviewController')->only(['show', 'store']);
Route::get('/booking-by-review/{reviewKey}', 'BookingByReviewController');
Route::post('checkout', 'CheckoutController')->name('checkout');
