<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'ticket_num' => $this->ticket_num,
            'seat_num' => $this->seat?->seat_num??'',
            'start_station' => $this->startStation?->name_ar??'',
            'end_station' => $this->endStation?->name_ar??'',
        ];
    }
}
