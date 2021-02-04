<?php

namespace Tests\Feature\Commands;

use App\Jobs\FlightCloser;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Flight;
use App\Console\Commands\CloseFlight;
use Illuminate\Support\Facades\Queue;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property Collection $activeFlights
 */
class CloseFlightCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->activeFlights = Flight::factory(
            [
                'last_seen_at' => Carbon::now()->subMinutes(3)
            ]
        )
            ->count(40)
            ->create();
        Queue::fake();
    }

    /** @test */
    public function it_will_dispatch_the_flight_closer_job()
    {
        // Some "inactive" flights
        Flight::factory(
            [
                'last_seen_at' => Carbon::now()->subMinutes(30)
            ]
        )
            ->count(5)
            ->create();

        $this->artisan(CloseFlight::class)->execute();
        Queue::assertPushed(FlightCloser::class);
    }

    /** @test */
    public function it_will_not_dispatch_any_jobs_if_there_are_zero_inactive_flights()
    {
        $this->artisan(CloseFlight::class)->execute();
        Queue::assertNotPushed(FlightCloser::class);
    }
}
