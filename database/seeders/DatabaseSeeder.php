<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        if (DailyStats::count() === 0) {
            $this->call(FlightSeeder::class);
        }
    }
}
