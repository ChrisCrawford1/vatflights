<?php

namespace App\Vatsim\Pipeline\Stages;

use App\Models\Callsign;
use Closure;

class ProcessCallsign
{
    public function handle(array $flight, Closure $next)
    {
        $data = [];

        $callsign = Callsign::firstOrCreate(
            [
                'callsign' => $flight['callsign']
            ],
        );

        $data['callsign'] = $callsign;
        $data['flight'] = $flight;

        return $next($data);
    }
}
