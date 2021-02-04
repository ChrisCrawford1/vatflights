<?php

namespace Tests\Unit\Observers;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Flight;
use App\Models\Callsign;
use App\Models\DailyStats;
use App\Observers\FlightObserver;
use App\Observers\CallsignObserver;
use App\Observers\DailyStatsObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BaseObserverTest extends TestCase
{
    use RefreshDatabase;

    private const OBSERVER_MODEL = [
        Callsign::class => CallsignObserver::class,
        Flight::class => FlightObserver::class,
        DailyStats::class => DailyStatsObserver::class,
    ];

    /** @test */
    public function it_can_generate_a_uuid_for_a_model_on_creating()
    {
        foreach (self::OBSERVER_MODEL as $model => $observer) {
            $model = (app($model))->factory()->make();
            $this->assertNull($model->uuid);

            (app($observer))->creating($model);
            $this->assertNotNull($model->uuid);
        }
    }

    /** @test */
    public function it_can_generate_todays_date_when_daily_stats_are_created()
    {
        $dailyStats = DailyStats::factory()
            ->create();

        $this->assertEquals(Carbon::today(),$dailyStats->date);
    }
}
