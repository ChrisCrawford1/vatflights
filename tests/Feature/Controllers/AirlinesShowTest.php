<?php


namespace Tests\Feature\Controllers;

use App\Models\Airline;
use App\Models\Callsign;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Model;
use Tests\FeatureTestCase;

/**
 * @property Model airline
 * @property Model callsign
 * @property Model flight
 */
class AirlinesShowTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->airline = Airline::factory()->create();
        $this->callsign = Callsign::factory(
            [
                'airline_id' => $this->airline->id,
            ]
        )->create();
        $this->flight = Flight::factory(
            [
                'callsign_id' => $this->callsign->id,
            ]
        )->create();
    }

    /** @test */
    public function it_can_show_an_airline()
    {
        $response = $this->get(route('airlines.show', $this->airline->uuid));
        $response->assertSuccessful();
        $response->assertViewIs('airlines.show');
        $response->assertSee($this->airline->name);
        $response->assertSee($this->callsign->callsign);
    }
}
