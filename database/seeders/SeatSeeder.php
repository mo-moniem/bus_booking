<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Seat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Seat::truncate();
        Schema::enableForeignKeyConstraints();

        $buses = Bus::pluck('id')->toArray();
        foreach ($buses as $bus) {
            for ($i = 1; $i <= 12; $i++) {
                Seat::create([
                    'bus_id' => $bus,
                    'seat_num' => $i,
                ]);
            }

        }
    }
}
