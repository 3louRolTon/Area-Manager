<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class City extends JsonResource
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
            'name' => $this->city_name,
            'type' => $this->city_type,
            'category' => $this->city_category,
            'district_id' => $this->district_id,
            'spot_id' => $this->spot_id,
        ];
    }
}
