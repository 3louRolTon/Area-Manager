<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Deputat extends JsonResource
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
            'district' => $this->district,
            'biography' => $this->biography,
            'district_id' => $this->district_id,
        ];
    }
}
