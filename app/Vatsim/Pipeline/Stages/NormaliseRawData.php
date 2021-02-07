<?php

namespace App\Vatsim\Pipeline\Stages;

use App\Vatsim\Helpers\Aircraft;
use Closure;

class NormaliseRawData
{
    public function handle(array $flight, Closure $next)
    {
        $flight['flight_plan']['aircraft'] = Aircraft::findICAO($flight['flight_plan']['aircraft']);

        return $next($flight);
    }
}
