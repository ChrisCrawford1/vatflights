<?php

namespace App\Jobs;

use App\Models\DailyStats;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessGeneralData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $generalData;

    /**
     * Create a new job instance.
     *
     * @param array $generalData
     */
    public function __construct(array $generalData)
    {
        $this->generalData = $generalData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dailyStats = DailyStats::today()->first();
        if ($dailyStats === null) {
            DailyStats::create(
                [
                    'max_connected_users' => $this->generalData['connected_clients']
                ]
            );
            return;
        }

        if ($this->generalData['connected_clients'] > $dailyStats->max_connected_users) {
            $dailyStats->update(
                [
                    'max_connected_users' => $this->generalData['connected_clients'],
                ]
            );
        }
    }
}
