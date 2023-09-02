<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvailableSeatRequest;
use App\Http\Requests\TripSeatRequest;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TripSeatResource;
use App\Models\Trip;
use App\Repositories\Contracts\TripContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeatBookingController extends Controller
{
    /**
     * @var TripContract
     */
    public $repo;

    /**
     * @param TripContract $repo
     */
    public function __construct(TripContract $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param AvailableSeatRequest $request
     * @return JsonResponse
     */
    public function getAvailableTripSeat(AvailableSeatRequest $request):JsonResponse{
        $tripSeats = $this->repo->getAvailableTripSeat($request->validated());
        return response()->json(['status'=>true,'data'=>TripSeatResource::collection($tripSeats->get())]);
    }

    /**
     * @param TripSeatRequest $request
     * @param Trip $trip
     * @return JsonResponse
     */
    public function tripSeatBooking(TripSeatRequest $request, Trip $trip):JsonResponse{
        $ticket = $this->repo->tripSeatBooking($request->validated(),$trip);
        $ticket = $ticket->load(['seat','startStation','endStation']);
        return response()->json(['status'=>true,'data'=>new TicketResource($ticket)]);
    }
}
