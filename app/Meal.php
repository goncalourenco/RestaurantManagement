<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use App\RestaurantTable;
use App\User;

class Meal extends Model
{
    protected $fillable = [
        'table_number','responsible_waiter_id', 'start', 'end'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'meal_id');
    }

    public function orders_delivered()
    {
        return $this->hasMany(Order::class, 'meal_id')->where('state', 'delivered');
    }

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class, 'table_number');
    }

    public function waiter(){
        return $this->belongsTo(User::class, 'responsible_waiter_id');
    }
}
