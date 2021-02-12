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

    /** @test */
    public function it_can_normalise_f350_as_a_regular_altitude()
    {
        $flight = $this->testData->getJsonData()['pilots'][0];
        $flight['flight_plan']['altitude'] = 'F350';

        (new NormaliseRawData())
            ->handle($flight, function ($return) {
                $this->assertEquals('35000', $return['flight_plan']['altitude']);
            });
    }

    /** @test */
    public function it_can_normalise_FL360_as_a_regular_altitude()
    {
        $flight = $this->testData->getJsonData()['pilots'][0];
        $flight['flight_plan']['altitude'] = 'FL360';

        (new NormaliseRawData())
            ->handle($flight, function ($return) {
                $this->assertEquals('36000', $return['flight_plan']['altitude']);
            });
    }

    /** @test */
    public function it_will_change_an_altitude_like_270_to_27000()
    {
        $flight = $this->testData->getJsonData()['pilots'][0];
        $flight['flight_plan']['altitude'] = '270';

        (new NormaliseRawData())
            ->handle($flight, function ($return) {
                $this->assertEquals('27000', $return['flight_plan']['altitude']);
            });
    }

    /** @test */
    public function it_will_not_change_a_sub_flight_altitude()
    {
        $flight = $this->testData->getJsonData()['pilots'][0];
        $flight['flight_plan']['altitude'] = '4000';

        (new NormaliseRawData())
            ->handle($flight, function ($return) {
                $this->assertEquals('4000', $return['flight_plan']['altitude']);
            });
    }

    /** @test */
    public function it_will_not_modify_an_altitude_like_36000()
    {
        $flight = $this->testData->getJsonData()['pilots'][0];
        $flight['flight_plan']['altitude'] = '36000';

        (new NormaliseRawData())
            ->handle($flight, function ($return) {
                $this->assertEquals('36000', $return['flight_plan']['altitude']);
            });
    }

    /** @test */
    public function it_will_change_an_altitude_like_FL050_to_5000()
    {
        $flight = $this->testData->getJsonData()['pilots'][0];
        $flight['flight_plan']['altitude'] = 'FL050';

        (new NormaliseRawData())
            ->handle($flight, function ($return) {
                $this->assertEquals('5000', $return['flight_plan']['altitude']);
            });
    }
}
