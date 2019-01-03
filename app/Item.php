<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\InvoiceItem;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id','name','type','description','photo_url', 'price',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
