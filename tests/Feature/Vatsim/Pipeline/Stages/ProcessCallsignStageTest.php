<?php

namespace Tests\Feature\Vatsim\Pipeline\Stages;

use App\Models\Airline;
use App\Vatsim\Pipeline\Stages\ProcessCallsign;
use Tests\FeatureTestCase;
use Tests\Helpers\Data\TestVatsimData;

/**
 * @property TestVatsimData testData
 */
class ProcessCallsignStageTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = new TestVatsimData();
    }

    /** @test */
    public function it_can_create_a_new_callsign()
    {
        Airline::factory()
            ->create(
                [
                    'name' => 'Air Portugal',
                    'icao' => 'TAP',
                ]
            );
        $flight = $this->testData->getJsonData()['pilots'][0];

        (new ProcessCallsign())
            ->handle($flight, function ($return) {
                $this->assertDatabaseHas(
                    'callsigns',
                    [
                        'callsign' => $return['callsign']->callsign
                    ]
                );
            });
    }

    /** @test */
    public function it_will_return_a_callsign_attached_toThe_unknown_airline_if_the_icao_isnt_recognised()
    {
        $unknown = Airline::factory()
            ->create(
                [
                    'name' => 'Unknown',
                    'icao' => '???',
                ]
            );

        $flight = $this->testData->getJsonData()['pilots'][0];

        (new ProcessCallsign())
            ->handle($flight, function ($return) use ($unknown) {
                $this->assertDatabaseHas(
                    'callsigns',
                    [
                        'callsign' => $return['callsign']->callsign,
                        'airline_id' => $unknown->id
                    ]
                );
            });
    }
}
