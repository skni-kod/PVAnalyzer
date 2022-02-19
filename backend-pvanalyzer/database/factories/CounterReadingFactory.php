<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
class CounterReadingFactory extends Factory
{
    private $oldActive = 0;
    private $oldReactive =0;
    
    private $startDate = '2022-01-01 03:32:05';
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $temp = Carbon::create($this->startDate);
        $newDate = $temp->addDays(9)->format('Y-m-d');

        $active_energy_consumed =  $this->oldActive + $this->faker->randomFloat(2, 1, 200);
        $this->oldActive = $active_energy_consumed;
        $reactive_energy_consumed = $this->oldReactive + $this->faker->randomFloat(2, 1, 200);
        $this->oldReactive = $reactive_energy_consumed;
        $this->startDate = $newDate;
        return [
            'p_v_installation_id' => 9,
            'date' => $newDate,
            'active_energy_consumed' => $active_energy_consumed,
            'reactive_energy_consumed' => $reactive_energy_consumed,
            'energy_to_recover' => $reactive_energy_consumed * 0.8,
            'balance' => ($reactive_energy_consumed * 0.8) - $active_energy_consumed
        ];
    }
}
