<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id','item_id','quantity','unit_price','sub_total_price'
    ];

    protected $table = 'invoice_items';

    protected $primaryKey = ['invoice_id', 'item_id'];

    public $incrementing = false;

    public $timestamps = false;

    public function item()
    {
        return $this->belongsTo(Item::class);
    }	

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
