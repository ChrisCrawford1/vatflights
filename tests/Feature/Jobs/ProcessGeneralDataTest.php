<?php

namespace Tests\Feature\Jobs;

use App\Jobs\ProcessGeneralData;
use App\Models\DailyStats;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\FeatureTestCase;

class ProcessGeneralDataTest extends FeatureTestCase
{
    use RefreshDatabase;

    private array $generalData = [
        'version' => 3,
        'reload' => 1,
        'update' => '20210205075956',
        'update_timestamp' => '2021-02-05T07:59:56.9504851Z',
        'connected_clients' => 1534,
        'unique_users' => 1499
    ];

    /** @test */
    public function it_can_create_a_new_daily_stats_entry()
    {
        $this->assertDatabaseMissing(
            'daily_stats',
            [
                'date' => Carbon::today()
            ]
        );

        $processGeneralData = new ProcessGeneralData($this->generalData);
        $processGeneralData->handle();

        $this->assertDatabaseHas(
            'daily_stats',
            [
                'date' => Carbon::today(),
                'max_connected_users' => $this->generalData['connected_clients']
            ]
        );
    }

    /** @test */
    public function it_will_update_the_existing_daily_stats()
    {
        $dailyStats = DailyStats::factory(
            [
                'date' => Carbon::today(),
                'max_connected_users' => $this->generalData['connected_clients']
            ]
        )->create();

        $this->generalData['connected_clients'] = 1600;

        $this->assertNotEquals($this->generalData['connected_clients'], $dailyStats->max_connected_clients);

        $processGeneralData = new ProcessGeneralData($this->generalData);
        $processGeneralData->handle();

        $this->assertDatabaseHas(
            'daily_stats',
            [
                'date' => Carbon::today(),
                'max_connected_users' => $this->generalData['connected_clients']
            ]
        );
    }
}
