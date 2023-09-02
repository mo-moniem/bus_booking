<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AvailableTripSeat extends TestCase
{

    /**
     * @return void
     */
    public function test_available_trip_seats_need_login()
    {

        $response = $this->json('get','/api/available/trip/seats',[],['Accept' => 'application/json']);
        $response->assertStatus(401);
        $response->assertJson(['message'=>'Unauthenticated.']);
    }

    /**
     * @return void
     */
    public function test_available_trip_seats_without_data()
    {
        // logged in user
        $user = User::factory()->make();
        $this->actingAs($user);

        $response = $this->json('get','/api/available/trip/seats',[],['Accept' => 'application/json']);
        $response->assertStatus(422);
        $response->assertJson([
            "status"=> false,
            "message"=> "validation error",
            "details"=> [
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
    public function test_available_trip_seats_with_incorrect_data(){
        // logged in user
        $user = User::factory()->make();
        $this->actingAs($user);
        $body = [
            'start_station' => '16',
            'end_station' => '7'
        ];
        $response = $this->json('get','/api/available/trip/seats',$body,['Accept' => 'application/json']);
        $response->assertStatus(404);
        $response->assertJson([
            "status"=> false,
            "message"=> "No Available Trip Seats"
        ]);
    }

    /**
     * @return void
     */
    public function test_available_trip_seats_with_correct_data()
    {
        // logged in user
        $user = User::factory()->make();
        $this->actingAs($user);
        $body = [
            'start_station' => '1',
            'end_station' => '7'
        ];
        $response = $this->json('get','/api/available/trip/seats',$body,['Accept' => 'application/json']);
        if($response->status() === 404){
            $response->assertJson([
                "status"=>false,
                "message"=>"No Available Trip Seats"
            ]);
        }else{
            $response->assertJsonStructure([
                "status",
                "data"=>[
                    [
                        "trip_id",
                        "trip_num",
                        "bus_num",
                        "seats"=>[
                            [
                                "id",
                                "seat_num",
                            ]
                        ],
                    ]
                ]
            ]);
        }

    }
}
