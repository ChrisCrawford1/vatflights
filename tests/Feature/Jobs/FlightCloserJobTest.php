<?php

namespace Tests\Feature\Jobs;

use App\Jobs\FlightCloser;
use Tests\FeatureTestCase;
use Carbon\Carbon;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @property Collection flightsToBeClosed
 */
class FlightCloserJobTest extends FeatureTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->flightsToBeClosed = Flight::factory(
            [
                'last_seen_at' => Carbon::now()->subMinutes(25),
                'complete' => false
            ]
        )
            ->count(10)
            ->create();
    }

    /** @test */
    public function it_will_complete_all_flights_provided_to_it()
    {
        $this->assertEquals(10, Flight::active()->count());

        (new FlightCloser($this->flightsToBeClosed))
            ->handle();

        $this->assertEquals(10, Flight::complete()->count());
        $this->assertEquals(0, Flight::active()->count());
    }
}
