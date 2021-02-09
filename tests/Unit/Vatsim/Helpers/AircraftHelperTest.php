<?php

namespace Tests\Unit\Vatsim\Helpers;

use App\Vatsim\Helpers\Aircraft;
use Tests\TestCase;

/**
 * @property array aircraftTypes
 */
class AircraftHelperTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->aircraftTypes = [
            'B77W/H-SDE1E2E3FGHIJ2J3J4J5M1RWXY/LB1D1' => 'B77W',
            'H/B78X/L' => 'B78X',
            'A319/M-SDE3FGHIRWY/LB1' => 'A319',
            'C172/U' => 'C172',
        ];
    }

    /** @test */
    public function it_can_produce_an_icao_from_different_strings()
    {
        foreach ($this->aircraftTypes as $rawString => $icao) {
            $this->assertEquals($icao, Aircraft::findICAO($rawString));
        }
    }

    /** @test */
    public function it_will_catch_cases_not_caught_in_the_regex_as_four_char_icao()
    {
        $this->assertEquals(
            'C172',
            Aircraft::findICAO('C172S')
        );
    }

    /** @test */
    public function it_will_return_the_string_its_provided_if_it_cannot_process_to_an_icao()
    {
        $this->assertEquals(
            'X2',
            Aircraft::findICAO('X2')
        );
    }
}
