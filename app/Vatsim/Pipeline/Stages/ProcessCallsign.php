<?php

namespace App\Vatsim\Pipeline\Stages;

use App\Models\Airline;
use App\Models\Callsign;
use Closure;
use Illuminate\Support\Facades\Log;

class ProcessCallsign
{
    public function handle(array $flight, Closure $next)
    {
        $data = [];

        $callsign = Callsign::firstOrCreate(
            [
                'airline_id' => $this->getAirline($flight['callsign'])->id,
                'callsign' => $flight['callsign']
            ],
        );

        $data['callsign'] = $callsign;
        $data['flight'] = $flight;

        return $next($data);
    }

    /**
     * @param string $callsign
     *
     * @return Airline
     */
    private function getAirline(string $callsign): Airline
    {
        $callsignIcao = substr($callsign, 0, 3);
        return Airline::whereIcao($callsignIcao)->firstOr(function () use ($callsignIcao) {
            return Airline::whereIcao('???')->first();
        });
    }
}
