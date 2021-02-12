<?php

namespace Database\Factories;

use App\Models\Airline;
use Illuminate\Database\Eloquent\Factories\Factory;

class AirlineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Airline::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'alias' => $this->faker->word,
            'icao' => $this->faker->companySuffix,
            'callsign' => $this->faker->unique()->word,
            'country' => $this->faker->country,
        ];
    }
}
