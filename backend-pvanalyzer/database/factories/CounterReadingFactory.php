<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CounterReadingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $active_energy_consumed =  $this->faker->randomFloat(2, 1, 200);
        $reactive_energy_consumed =  $this->faker->randomFloat(2, 1, 200);
        $dt = $this->faker->dateTimeBetween($startDate = '1.01.2022', $endDate = '31.12.2022');
        $date = $dt->format("Y-m-d");
        return [
            'p_v_installation_id' => 9,
            'date' => $date,
            //'date' => $this->faker->date(), //in future limit the date range
            'active_energy_consumed' => $active_energy_consumed,
            'reactive_energy_consumed' => $reactive_energy_consumed,
            'energy_to_recover' => $reactive_energy_consumed * 0.8,
            'balance' => ($reactive_energy_consumed * 0.8) - $active_energy_consumed
        ];
    }
}
