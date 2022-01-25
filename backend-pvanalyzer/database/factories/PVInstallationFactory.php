<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PVInstallationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->unique()->numberBetween($min = 2, $max = 9),
            'start' => $this->faker->date(),
            'power' => $this->faker->randomFloat(2, 1, 9.99),
        ];
    }
}
