<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Meal;
use App\Item;

class Order extends Model
{
    protected $fillable = [
        'id','state','item_id','meal_id','responsible_cook_id','start','end'
   ];

   public function cookers()
   {
       return $this->belongsTo(User::class, 'responsible_cook_id');
   }

   public function meals()
   {
       return $this->belongsTo(Meal::class, 'meal_id');
   }


   public function item()
   {
       return $this->belongsTo(Item::class, 'item_id');
   }

}
