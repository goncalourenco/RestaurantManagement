<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceItem extends JsonResource
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
            'invoice_id' => $this->invoice_id,
            'item_id' => $this->item_id,
            'item_name' => $this->item->name,
            'item_price' => $this->item->price,
            'quantity' => $this->quantity,
            'sub_total_price' => $this->sub_total_price
        ];
    }
}
