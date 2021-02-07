<?php

namespace Tests\Feature\Vatsim\Pipeline;

use App\Vatsim\Pipeline\FlightProcessor;
use Tests\FeatureTestCase;
use Tests\Helpers\Data\TestVatsimData;

/**
 * @property TestVatsimData testData
 */
class FlightProcessorTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = new TestVatsimData();
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
}
