<?php

namespace Database\Factories;

use App\Models\Bus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $buses = Bus::pluck('id')->toArray();
        return [
            'trip_num' => fake()->unique()->randomDigit('5'),
            'bus_id' => $buses[array_rand($buses)],
        ];
    }
}
