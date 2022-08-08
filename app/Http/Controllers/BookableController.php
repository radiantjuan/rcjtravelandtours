<?php
/**
 * Bookable Controller
 * Handles showing the list of bookable resorts and showing each
 *
 * @author    Radiant Juan <radiantcjuan@gmail.com>
 * @copyright RCJWorks 2022
 */

namespace App\Http\Controllers;

use App\Bookable;
use App\Http\Resources\BookableIndexResource;
use Illuminate\Http\Request;

class BookableController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request) {
        return BookableIndexResource::collection(Bookable::all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return Bookable::findOrFail($id);
    }
}
