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
     * @param array $request
     * @return mixed
     */
    public function getAvailableTripSeat(array $request);

    /**
     * @param array $attributes
     * @param Trip $trip
     * @return mixed
     */
    public function tripSeatBooking(array $attributes, Trip $trip);
}
