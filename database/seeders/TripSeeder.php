<?php

namespace Database\Seeders;

use App\Models\Trip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        schema::disableForeignKeyConstraints();
        Trip::truncate();
        Schema::enableForeignKeyConstraints();
        $trips = [
            [
                'trip_num'=>122,
                'bus_id'=>1,
                'start_station' => ['1','7','11'],
                'end_station' => ['7','11','16'],
            ]
        ];
        foreach ($trips as $trip){
            $trip = Trip::create($trip);
            $start_station = $trip->start_station;
            $end_station = $trip->end_station;
            $available_stations = array_values(array_unique(array_merge($start_station,$end_station)));
            $trip->seats()->update([
                'available_stations'=> $available_stations
            ]);
        }
    }
}
