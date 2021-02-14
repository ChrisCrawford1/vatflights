<?php

namespace App\Vatsim\Pipeline\Stages;

use App\Models\Flight;
use Carbon\Carbon;
use Closure;

class ProcessFlight
{
    public function handle(array $data, Closure $next)
    {
        $activeCallsign = $data['callsign']
            ->flights()
            ->active();

        $rawFlightData = $data['flight'];

        if ($activeCallsign->count() === 0) {
            $storedFlight = Flight::create(
                [
                    'callsign_id' => $data['callsign']->id,
                    'flight_rules' => $rawFlightData['flight_plan']['flight_rules'],
                    'aircraft_type' => $rawFlightData['flight_plan']['aircraft'],
                    'departure' => $rawFlightData['flight_plan']['departure'],
                    'arrival' => $rawFlightData['flight_plan']['arrival'],
                    'alternate' => $rawFlightData['flight_plan']['alternate'] ?? Flight::UNKNOWN_PROPERTY,
                    'route' => $rawFlightData['flight_plan']['route'] ?? Flight::UNKNOWN_PROPERTY,
                    'transponder' => (int) $rawFlightData['transponder'],
                    'planned_altitude' => $rawFlightData['flight_plan']['altitude'] ?? Flight::UNKNOWN_PROPERTY,
                    'logged_in_at' => Carbon::parse($rawFlightData['logon_time']),
                    'last_seen_at' => Carbon::parse($rawFlightData['last_updated']),
                ]
            );

            // Overwrite the raw data with the concrete stored data.
            $data['flight'] = $storedFlight;
            return $next($data);
        }
        
        $activeFlight = $activeCallsign->first();

        $activeFlight->update(
            [
                'last_seen_at' => Carbon::parse($rawFlightData['last_updated']),
            ]
        );

        return $next($data);
    }
}
