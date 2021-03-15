<?php

namespace Tests\Feature\Commands;

use App\Console\Commands\ProcessPopularStats;
use App\Models\Airline;
use App\Models\Callsign;
use App\Models\DailyStats;
use App\Models\Flight;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Tests\FeatureTestCase;

/**
 * @property Model ba
 * @property Model baCallsigns
 * @property Model american
 * @property Model americanCallsign
 */
class ProcessPopularStatsTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DailyStats::factory(
            [
                'date' => Carbon::today()
            ]
        )->create();

        $this->ba =  Airline::factory(
            [
                'name' => 'British Airways',
                'alias' => 'BA',
                'icao' => 'BAW',
                'callsign' => 'SPEEDBIRD',
                'country' => 'United Kingdom',
            ]
        )->create();

        $this->baCallsigns = Callsign::factory(
            [
                'airline_id' => $this->ba->id,
            ]
        )
            ->count(2)
            ->create();

        $this->american =  Airline::factory(
            [
                'name' => 'American Airlines',
                'icao' => 'AAL',
                'callsign' => 'AMERICAN',
                'country' => 'United Kingdom',
            ]
        )->create();

        $this->americanCallsign = Callsign::factory(
            [
                'airline_id' => $this->ba->id,
                'callsign' => 'AAL34'
            ]
        )->create();
    }

    /** @test */
    public function it_can_generate_an_update_to_the_current_daily_stats()
    {
        Flight::factory(
            [
                'callsign_id' => $this->baCallsigns->first()->id,
                'departure' => 'EGLL',
                'arrival' => 'TNCM',
                'aircraft_type' => 'B78X',
                'complete' => true,
                'arrival_date' => Carbon::today(),
                'created_at' => Carbon::now()->subHours(2),
            ]
        )->create();

        Flight::factory(
            [
                'callsign_id' => $this->baCallsigns->first()->id,
                'departure' => 'EGLL',
                'arrival' => 'EGPH',
                'aircraft_type' => 'A320',
                'created_at' => Carbon::now()->subHour(),
            ]
        )->create();

        Flight::factory(
            [
                'callsign_id' => $this->americanCallsign->id,
                'departure' => 'KLAX',
                'arrival' => 'KJFK',
                'complete' => false,
                'aircraft_type' => 'A320',
                'created_at' => Carbon::now()->subHour(),
            ]
        );

        $this->artisan(ProcessPopularStats::class);

        $this->assertDatabaseHas(
            'daily_stats',
            [
                'most_popular_aircraft' => 'A320',
                'aircraft_uses' => 1,
                'most_popular_airline' => 'British Airways',
                'callsign_uses' => 2,
                'most_popular_departure' => 'EGLL',
                'departure_count' => 2,
                'most_popular_arrival' => 'TNCM',
                'arrival_count' => 1,
            ]
        );

    }
}
