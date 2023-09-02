<?php

namespace Tests\Feature;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TripSeatBooking extends TestCase
{
    /**
     * @return void
     */
    public function test_trip_seat_booking_without_trip_id()
    {
        $trip = Trip::factory()->make();
        $response = $this->json('post',"/api/trip/".$trip->id."/seat",[],['Accept' => 'application/json']);
        $response->assertStatus(404);
    }

    /**
     * @return void
     */
    public function test_trip_seat_booking_without_login()
    {
        $trip = Trip::find(1);
        $response = $this->json('post',"/api/trip/".$trip->id."/seat",[],['Accept' => 'application/json']);
        $response->assertStatus(401);
        $response->assertJson(['message'=>'Unauthenticated.']);
    }

    /**
     * @return void
     */
    public function test_trip_seat_booking_without_data()
    {
        $trip = Trip::find(1);
        // logged in user
        $user = User::factory()->make();
        $this->actingAs($user);

        $response = $this->json('post',"/api/trip/".$trip->id."/seat",[],['Accept' => 'application/json']);
        $response->assertStatus(422);
        $response->assertJson([
            "status"=> false,
            "message"=> "Invalid data send",
            "details"=> [
                "seat_id"=> [
                    "The seat id field is required."
                ],
                "start_station"=> [
                    "The start station field is required."
                ],
                "end_station"=> [
                    "The end station field is required."
                ]
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_trip_seat_booking_without_correct_data()
    {
        $trip = Trip::find(1);
        // logged in user
        $user = User::factory()->make();
        $this->actingAs($user);
        $tripSeats = $trip->seats()->pluck('seats.id')->toArray();
        $body = [
            "seat_id"=> $tripSeats[array_rand($tripSeats)],
            'start_station' => '7',
            'end_station' => '11'
        ];
        $response = $this->json('post',"/api/trip/".$trip->id."/seat",$body,['Accept' => 'application/json']);
        if($response->status() === 404){
            $response->assertJson([
                "status"=> false,
                "message"=> "Seat Already Booked"
            ]);
        }else{
            $response->assertJsonStructure([
                "status",
                "data"=>[
                    "id",
                    "ticket_num",
                    "seat_num",
                    "start_station",
                    "end_station",
                ]
            ]);
        }
    }

}
