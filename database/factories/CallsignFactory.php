<?php

namespace Database\Factories;

use App\Models\Callsign;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CallsignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Callsign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'callsign' => $this->faker->unique()->word,
        ];
    }
}
