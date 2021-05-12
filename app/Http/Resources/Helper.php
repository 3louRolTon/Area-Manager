<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Helper extends JsonResource
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
            'name1' => $this->name1,
            'name2' => $this->name2,
            'name3' => $this->name3,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'information' => $this->information,
            'deputat_id' => $this->deputat_id,
        ];
    }
}
