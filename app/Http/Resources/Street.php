<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Street extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->street_name,
            'type' => $this->street_type,
            'city_id' => $this->city_id,
        ];
    }
}
