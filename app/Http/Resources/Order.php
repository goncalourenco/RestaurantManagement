<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'state' => $this->state,
            'item_id' => $this->item_id,
            'item_name' => $this->item->name,
            'item_price' => $this->item->price,
            'item_type' => $this->item->type,
            'meal_id' => $this->meal_id,
            'table_number' => $this->meal->table_number,
            'responsible_cook_id' => $this->responsible_cook_id,
            'start' => $this->start,
            'waiter_id' => $this->meal->resposible_waiter_id, 
            'end' => $this->end
        ];
    }
}