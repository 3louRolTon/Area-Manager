<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class House extends JsonResource
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
            'number' => $this->house_number,
            'info' => $this->information,
            'street_id' => $this->street_id,
            'spot_id' => $this->spot_id,
        ];
    }
}
