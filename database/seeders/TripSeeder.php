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
                'start_station' => json_encode(['1','7','11']),
                'end_station' => json_encode(['7','11','16']),
            ]
        ];

        Trip::insert($trips);
    }
}
