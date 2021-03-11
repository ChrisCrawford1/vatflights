<?php

namespace Tests\Feature\Services;

use App\Models\Flight;
use App\Services\FlightStatisticsDataService;
use Carbon\Carbon;
use Tests\FeatureTestCase;

class FlightStatisticsDataServiceTest extends FeatureTestCase
{
    /** @test */
    public function it_can_retrieve_the_most_used_aircraft()
    {
        Flight::factory(
            [
                'aircraft_type' => 'A320',
            ]
        )
            ->count(10)
            ->create();

        Flight::factory(
            [
                'aircraft_type' => 'B738',
            ]
        )
            ->count(5)
            ->create();

        Flight::factory(
            [
                'aircraft_type' => 'MD11',
            ]
        )
            ->count(9)
            ->create();

        $statsService = new FlightStatisticsDataService();
        $mostPopularAircraft = $statsService->getMostPopularFromDataType('aircraft_type')->first();

        $this->assertEquals('A320', $mostPopularAircraft->aircraft_type);
        $this->assertEquals(10, $mostPopularAircraft->count);
    }

    /** @test */
    public function it_will_return_null_if_there_is_no_valid_data_for_today()
    {
        $this->assertNull(
            (new FlightStatisticsDataService())
                ->getMostPopularFromDataType('aircraft_type')
                ->first()
        );
    }

    /** @test */
    public function it_will_return_null_if_there_is_data_from_yesterday_but_not_today()
    {
        Flight::factory(
            [
                'aircraft_type' => 'B738',
                'created_at' => Carbon::yesterday(),
            ]
        )
            ->count(5)
            ->create();

        Flight::factory(
            [
                'aircraft_type' => 'MD11',
                'created_at' => Carbon::yesterday(),
            ]
        )
            ->count(9)
            ->create();

        $this->assertNull(
            (new FlightStatisticsDataService())
                ->getMostPopularFromDataType('aircraft_type')
                ->first()
        );
    }

    /** @test */
    public function it_will_return_an_aircraft_from_today_but_not_yesterday()
    {
        Flight::factory(
            [
                'aircraft_type' => 'B738',
                'created_at' => Carbon::yesterday(),
            ]
        )
            ->count(5)
            ->create();

        Flight::factory(
            [
                'aircraft_type' => 'B738',
                'created_at' => Carbon::now()->subHour(),
            ]
        )
            ->count(3)
            ->create();

        Flight::factory(
            [
                'aircraft_type' => 'A320',
                'created_at' => Carbon::now()->subHour(),
            ]
        )
            ->count(9)
            ->create();

        $statsService = new FlightStatisticsDataService();
        $mostPopularAircraft = $statsService
            ->getMostPopularFromDataType('aircraft_type')
            ->first();

        $this->assertEquals('A320', $mostPopularAircraft->aircraft_type);
        $this->assertEquals(9, $mostPopularAircraft->count);
    }

    /** @test */
    public function it_can_retrieve_the_most_popular_departure_airfield()
    {
        Flight::factory(
            [
                'departure' => 'EGLL',
                'aircraft_type' => 'B738',
                'complete' => false,
                'created_at' => Carbon::now()->subHours(2),
            ]
        )
            ->count(5)
            ->create();

        Flight::factory(
            [
                'departure' => 'KLAX',
                'complete' => false,
                'aircraft_type' => 'B78X',
                'created_at' => Carbon::now()->subHour(),
            ]
        )
            ->count(4)
            ->create();

        $statsService = new FlightStatisticsDataService();
        $mostPopularDeparture = $statsService
            ->getMostPopularFromDataType('departure')
            ->first();

        $this->assertEquals('EGLL', $mostPopularDeparture->departure);
        $this->assertEquals(5, $mostPopularDeparture->count);
    }

    /** @test */
    public function test_it_can_retrieve_the_most_popular_arrival_airfield()
    {
        Flight::factory(
            [
                'departure' => 'EGLL',
                'arrival' => 'TNCM',
                'aircraft_type' => 'B78X',
                'complete' => true,
                'arrival_date' => Carbon::today(),
                'created_at' => Carbon::now()->subHours(2),
            ]
        )
            ->count(2)
            ->create();

        Flight::factory(
            [
                'departure' => 'KLAX',
                'arrival' => 'KJFK',
                'complete' => true,
                'arrival_date' => Carbon::today(),
                'aircraft_type' => 'B78X',
                'created_at' => Carbon::now()->subHour(),
            ]
        )
            ->count(4)
            ->create();

        $statsService = new FlightStatisticsDataService();
        $mostPopularArrival = $statsService
            ->getMostPopularAirfield('arrival', true)
            ->first();

        $this->assertEquals('KJFK', $mostPopularArrival->arrival);
        $this->assertEquals(4, $mostPopularArrival->count);
    }

    /** @test */
    public function it_will_exclude_flights_in_progress_when_calculating_most_popular_arrival()
    {
        Flight::factory(
            [
                'departure' => 'EGLL',
                'arrival' => 'TNCM',
                'aircraft_type' => 'B78X',
                'complete' => true,
                'arrival_date' => Carbon::today(),
                'created_at' => Carbon::now()->subHours(2),
            ]
        )
            ->count(2)
            ->create();

        Flight::factory(
            [
                'departure' => 'KLAX',
                'arrival' => 'KJFK',
                'complete' => true,
                'arrival_date' => Carbon::today(),
                'aircraft_type' => 'B78X',
                'created_at' => Carbon::now()->subHour(),
            ]
        )
            ->count(4)
            ->create();

        Flight::factory(
            [
                'departure' => 'KLAX',
                'arrival' => 'KJFK',
                'complete' => false,
                'aircraft_type' => 'B78X',
                'created_at' => Carbon::now()->subHour(),
            ]
        )
            ->create();

        $statsService = new FlightStatisticsDataService();
        $mostPopularArrival = $statsService
            ->getMostPopularAirfield('arrival', true)
            ->first();

        $this->assertEquals('KJFK', $mostPopularArrival->arrival);
        $this->assertEquals(4, $mostPopularArrival->count);
    }
}
