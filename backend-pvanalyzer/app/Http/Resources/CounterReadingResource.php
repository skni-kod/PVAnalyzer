<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CounterReadingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'active_energy_consumed' => $this->active_energy_consumed,
            'reactive_energy_consumed' => $this->reactive_energy_consumed,
            'energy_to_recover' => $this->energy_to_recover
        ];
    }
}
