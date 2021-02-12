<?php

namespace Tests\Feature\Vatsim\Pipeline;

use App\Models\Airline;
use App\Models\Callsign;
use App\Models\Flight;
use App\Vatsim\Pipeline\FlightProcessor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Tests\FeatureTestCase;
use Tests\Helpers\Data\TestVatsimData;

/**
 * @property TestVatsimData testData
 * @property Model airline
 */
class FlightProcessorTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = new TestVatsimData();
        $this->airline = Airline::factory()
            ->create(
                [
                    'name' => 'Air Portugal',
                    'icao' => 'TAP'
                ]
            );
    }

    /** @test */
    public function it_can_fully_process_a_flight()
    {
        $flight = $this->testData->getJsonData()['pilots'][0];
        $processor = new FlightProcessor();
        $processedData = $processor->run($flight);

        $this->assertArrayHasKey('callsign', $processedData);
        $this->assertArrayHasKey('flight', $processedData);

        $this->assertEquals($flight['callsign'], $processedData['callsign']->callsign);
        $this->assertEquals('A319', $processedData['flight']->aircraft_type);
    }

    /** @test */
    public function it_will_update_the_last_seen_at_for_an_existing_flight_on_a_callsign()
    {
        $rawFlight = $this->testData->getJsonData()['pilots'][0];
        $callsign = Callsign::factory()
            ->create(
                [
                    'airline_id' => $this->airline->id,
                    'callsign' => $rawFlight['callsign']
                ]
            );

        $flight = Flight::factory()
            ->create(
                [
                    'callsign_id' => $callsign->id,
                    'departure' => $rawFlight['flight_plan']['departure'],
                    'arrival' => $rawFlight['flight_plan']['arrival'],
                    'logged_in_at' => $rawFlight['logon_time'],
                    'last_seen_at' => $rawFlight['last_updated']
                ]
            );

        $rawFlight['last_updated'] = Carbon::now();

        (new FlightProcessor())
            ->run($rawFlight);

        $this->assertDatabaseHas(
            'flights',
            [
                'callsign_id' => $callsign->id,
                'last_seen_at' => Carbon::now()
            ]
        );

    }
}
