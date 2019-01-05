<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantTable extends JsonResource
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
            'table_number' => $this->table_number,
            'created_at' => $this->created_at->format('Y/m/d H:i'),
            'updated_at' => $this->updated_at->format('Y/m/d H:i')
        ];
    }
}
