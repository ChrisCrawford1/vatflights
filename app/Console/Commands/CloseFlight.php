<?php

namespace App\Console\Commands;

use App\Jobs\FlightCloser;
use App\Models\Flight;
use Illuminate\Console\Command;

class CloseFlight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vatflights:flights:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve all flights that match the specified window and set as complete.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Flight::flightsToBeCompleted()
            ->active()
            ->chunk(100, function ($chunk) {
                FlightCloser::dispatch($chunk);
            });

        return 1;
    }
}
