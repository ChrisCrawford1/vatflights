<?php

namespace App\Vatsim\Pipeline;

use App\Vatsim\Pipeline\Stages\NormaliseRawData;
use App\Vatsim\Pipeline\Stages\ProcessCallsign;
use App\Vatsim\Pipeline\Stages\ProcessFlight;
use Illuminate\Pipeline\Pipeline;

class FlightProcessor
{
    private const PIPES = [
        NormaliseRawData::class,
        ProcessCallsign::class,
        ProcessFlight::class,
    ];

    public function run($data)
    {
        return app(Pipeline::class)
            ->send($data)
            ->through(self::PIPES)
            ->then(function ($data) {
                return $data;
            });
    }
}
