<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PVInstallationResource extends JsonResource
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
            'start' => $this->start,
            'power' => $this->power,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
