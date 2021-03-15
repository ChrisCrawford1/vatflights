<?php

namespace App\Jobs;

use App\Models\Flight;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FlightCloser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Collection $flights;

    /**
     * @var int
     */
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @param Collection $flights
     */
    public function __construct(Collection $flights)
    {
        $this->flights = $flights;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var Flight $flight */
        foreach ($this->flights as $flight) {
            $flight->markFlightComplete();
        }
    }
}
