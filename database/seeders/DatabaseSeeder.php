<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Bus;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CitySeeder::class);
        $this->call(UserSeeder::class);

        Schema::disableForeignKeyConstraints();
        Bus::truncate();
        Schema::enableForeignKeyConstraints();
        Bus::factory(3)->create();
        $this->command->info('Bus table seeded!');

        $this->call(SeatSeeder::class);
        $this->call(TripSeeder::class);

    }
}
