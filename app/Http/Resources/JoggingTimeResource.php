<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JoggingTimeResource extends JsonResource
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
            'time' => $this->time_mins,
            'date' => $this->date,
            'distance' => $this->distance,
        ];
    }
}
