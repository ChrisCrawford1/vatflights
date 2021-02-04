<?php

namespace Database\Factories;

use App\Models\Callsign;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlightFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Flight::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'callsign_id' => Callsign::factory()->create(),
            'flight_rules' => 'I',
            'aircraft_type' => 'A320',
            'departure' => 'KLAX',
            'arrival' => 'KJFK',
            'alternate' => 'KLGA',
            'route' => 'DCT LOL',
            'planned_altitude' => 'FL360',
            'transponder' => $this->faker->randomNumber(4),
            'logged_in_at' => $this->faker->dateTime,
            'last_seen_at' => $this->faker->dateTime,
        ];
    }
}
