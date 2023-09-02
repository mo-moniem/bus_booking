<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\TripSeatRequest;
use App\Models\Trip;
use Illuminate\Http\Request;

interface TripContract
{
    /**
     * @param Trip $model
     */
    public function __construct(Trip $model);


    /**
     * @param Request $request
     * @return mixed
     */
    public function getAvailableTripSeat(Request $request);

    /**
     * @param array $attributes
     * @param Trip $trip
     * @return mixed
     */
    public function tripSeatBooking(Array $attributes, Trip $trip);
}
