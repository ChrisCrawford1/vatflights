<?php

namespace Tests\Feature\Vatsim\Pipeline\Stages;

use App\Vatsim\Pipeline\Stages\NormaliseRawData;
use Tests\FeatureTestCase;
use Tests\Helpers\Data\TestVatsimData;

/**
 * @property TestVatsimData testData
 */
class NormaliseDataStageTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = new TestVatsimData();
    }

    /** @test */
    public function it_can_return_a_closure_with_normalised_data()
    {
        $flight = $this->testData->getJsonData()['pilots'][0];

        (new NormaliseRawData())
            ->handle($flight, function ($return) {
                $this->assertEquals('A319', $return['flight_plan']['aircraft']);
            });

    }
}
