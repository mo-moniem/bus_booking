<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripSeatResource extends JsonResource
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
            'trip_id' => $this->id,
            'trip_num' => $this->trip_num,
            'bus_num' => $this->bus?->bus_num??'',
            'seats' => $this->relationLoaded('seats')?SeatResource::collection($this->seats):[],
        ];
    }
}
