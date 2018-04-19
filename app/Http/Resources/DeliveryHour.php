<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryHour extends JsonResource
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
            'shop_id' => $this->shop_id,
            'market_id' => $this->market_id,
            'day_id' => $this->day_id,
            'day' => $this->day,
            'time_from' => $this->time_from,
		    'time_to' => $this->time_to,
            'slot_limit' => $this->slot_limit
        ];
    }
}
