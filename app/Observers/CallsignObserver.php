<?php

namespace App\Observers;

use App\Models\Callsign;
use Ramsey\Uuid\Uuid;

class CallsignObserver
{
    public function creating(Callsign $callsign): void
    {
        $callsign->uuid = Uuid::uuid4()->toString();
    }
}
