<?php

namespace Database\Seeders;

use App\Models\Airline;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use League\Csv\Reader;

class AirlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = Reader::createFromPath(storage_path('app/data/airlines.csv'));

        foreach ($records as $record) {
            Airline::create(
                [
                    'name' => $record[0],
                    'alias' => $record[1] === '\N' ? null : $record[1],
                    'icao' => $record[2],
                    'callsign' => Str::upper($record[3]),
                    'country' => $record[4],
                ]
            );
        }
    }
}
