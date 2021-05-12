<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Spot extends JsonResource
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
            'name' => $this->spot_name,
            'info' => $this->information,
            'phone_number' => $this->phone_number,
            'point_x' => $this->point_x,
            'point_y' => $this->point_y,
            'address' => $this->address,
            'district_id' => $this->district_id,
            'deputat_id' => $this->deputat_id,
        ];
    }
}
