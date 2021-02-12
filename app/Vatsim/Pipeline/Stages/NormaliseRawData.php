<?php

namespace App\Vatsim\Pipeline\Stages;

use App\Vatsim\Helpers\Aircraft;
use Closure;

class NormaliseRawData
{
    public function handle(array $flight, Closure $next)
    {
        $flight['flight_plan']['aircraft'] = Aircraft::findICAO($flight['flight_plan']['aircraft']);
        $flight['flight_plan']['altitude'] = Aircraft::normaliseAltitude($flight['flight_plan']['altitude']);

        return $next($flight);
    }
}
