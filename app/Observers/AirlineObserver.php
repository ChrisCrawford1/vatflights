<?php

namespace App\Observers;

use App\Models\Airline;
use Ramsey\Uuid\Uuid;

class AirlineObserver
{
    /**
     * @param Airline $airline
     */
    public function creating(Airline $airline)
    {
        $airline->uuid = Uuid::uuid4()->toString();
    }
}
