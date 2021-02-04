<?php

namespace App\Observers;

use App\Models\DailyStats;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class DailyStatsObserver
{
    /**
     * @param DailyStats $dailyStats
     */
    public function creating(DailyStats $dailyStats): void
    {
        $dailyStats->uuid = Uuid::uuid4()->toString();
        $dailyStats->date = Carbon::today();
    }
}
