<?php

namespace App\Repositories\SQL;

use App\Http\Requests\TripSeatRequest;
use App\Models\Ticket;
use App\Models\Trip;
use App\Repositories\Contracts\TripContract;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TripRepository implements TripContract
{

    public $model;

    /**
     * @param Trip $model
     */
    public function __construct(Trip $model){
        $this->model = $model;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getAvailableTripSeat(Request $request){
        $tripSeats = $this->model->with([
            "bus",
            "seats" => fn($q)=> $q->ofAvailableSeats($request),
        ])->ofAvailableTrip($request);
        if(!$tripSeats->exists()){
            return response()->json(['status'=>false,'message'=>'No Available Trip Seats'],404);
        }
        return $tripSeats;
    }

    /**
     * @param array $attributes
     * @param Trip $trip
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    public function tripSeatBooking(Array $attributes, Trip $trip){
        $check_seat_booked_before = $trip->tickets()->where('seat_id',$attributes['seat_id']);
        if(!$check_seat_booked_before->exists()){
            $ticket = $trip->tickets()->create([
                'user_id'=> auth()?->id()??1,
                'ticket_num' => $trip->id.'-'.$attributes['seat_id'].'-'.Str::random(8),
                'seat_id' => $attributes['seat_id'],
                'start_station_id' => $attributes['start_station'],
                'end_station_id' => $attributes['end_station'],
            ]);
            return $ticket;

        }
        else{
            $check_seat_booked_before = $check_seat_booked_before
                ->where(function ($q)use ($attributes){
                    $q->where('start_station_id',$attributes['start_station'])
                        ->orWhere('end_station_id',$attributes['end_station']);
                });

            if($check_seat_booked_before->exists()){
                $response = response()->json(['status'=>false,'message'=>'Seat Already Booked'],404);
                throw new HttpResponseException($response);
            }
            $ticket = $trip->tickets()->create([
                'user_id'=> auth()?->id()??1,
                'ticket_num' => $trip->id.'-'.$attributes['seat_id'].'-'.Str::random(8),
                'seat_id' => $attributes['seat_id'],
                'start_station_id' => $attributes['start_station'],
                'end_station_id' => $attributes['end_station'],
            ]);
            return $ticket;

        }
    }
}
