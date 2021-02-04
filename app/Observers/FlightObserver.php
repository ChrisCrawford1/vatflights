<?php

namespace App\Observers;

use App\Models\Flight;
use Ramsey\Uuid\Uuid;

class FlightObserver
{
    /**
     * @param Flight $flight
     */
    public function creating(Flight $flight): void
    {
        $flight->uuid = Uuid::uuid4()->toString();
    }
}
