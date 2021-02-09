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
        $mostPopularAircraft = $statsService->getMostPopularFromDataType('aircraft_type');

        $this->assertEquals('A320', $mostPopularAircraft->aircraft_type);
        $this->assertEquals(10, $mostPopularAircraft->count);
    }

    /** @test */
    public function it_will_return_null_if_there_is_no_valid_data_for_today()
    {
        $this->assertNull(
            (new FlightStatisticsDataService())
                ->getMostPopularFromDataType('aircraft_type')
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
        $mostPopularAircraft = $statsService->getMostPopularFromDataType('aircraft_type');

        $this->assertEquals('A320', $mostPopularAircraft->aircraft_type);
        $this->assertEquals(9, $mostPopularAircraft->count);
    }
}
