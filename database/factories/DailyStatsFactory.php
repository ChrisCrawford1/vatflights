<?php

namespace Database\Factories;

use App\Models\DailyStats;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyStatsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyStats::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'max_connected_users' => $this->faker->randomNumber(6),
        ];
    }
}
