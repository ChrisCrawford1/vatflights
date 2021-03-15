<?php

namespace App\Jobs;

use App\Vatsim\Pipeline\FlightProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class CallsignUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Collection
     */
    private Collection $pilots;

    /**
     * @var int
     */
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @param Collection $pilots
     */
    public function __construct(Collection $pilots)
    {
        $this->pilots = $pilots;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->pilots as $pilot) {
            if ($pilot['flight_plan'] === null) {
                continue;
            }

            (new FlightProcessor())
                ->run($pilot);
        }
    }
}
