<?php

namespace App\Jobs;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Models\Flight;
use App\Models\Callsign;
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

    private Collection $pilots;

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
            $callsign = Callsign::firstOrCreate(
                [
                    'callsign' => $pilot['callsign']
                ],
            );

            if ($pilot['flight_plan'] === null) {
                continue;
            }

            $activeFlight = $callsign->flights()->active();

            if ($activeFlight->count() === 0) {
                Flight::create(
                    [
                        'callsign_id' => $callsign->id,
                        'uuid' => Uuid::uuid4()->toString(),
                        'flight_rules' => $pilot['flight_plan']['flight_rules'],
                        'aircraft_type' => $pilot['flight_plan']['aircraft'],
                        'departure' => $pilot['flight_plan']['departure'],
                        'arrival' => $pilot['flight_plan']['arrival'],
                        'alternate' => $pilot['flight_plan']['alternate'] ?? Flight::UNKNOWN_PROPERTY,
                        'route' => $pilot['flight_plan']['route'] ?? Flight::UNKNOWN_PROPERTY,
                        'transponder' => (int) $pilot['transponder'],
                        'planned_altitude' => $pilot['flight_plan']['altitude'] ?? Flight::UNKNOWN_PROPERTY,
                        'logged_in_at' => Carbon::parse($pilot['logon_time']),
                        'last_seen_at' => Carbon::parse($pilot['last_updated']),
                    ]
                );
                continue;
            }

            $flight = $activeFlight->first();

            $flight->update(
                [
                    'last_seen_at' => Carbon::parse($pilot['last_updated']),
                ]
            );
        }
    }
}
