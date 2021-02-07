<?php

namespace Tests\Feature\Vatsim\Pipeline\Stages;

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
}
