<?php

namespace Database\Seeders;

use App\Models\Airline;
use App\Models\DailyStats;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (Airline::count() === 0) {
            $this->call(AirlineSeeder::class);
        }

        if (DailyStats::count() === 0) {
            $this->call(FlightSeeder::class);
        }
    }
}
