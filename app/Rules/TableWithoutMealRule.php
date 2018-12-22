<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\RestaurantTable;
use App\Meal;

class TableWithoutMealRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $meals = Meal::where('state', 'active')->get();
        foreach($meals as $meal){
            if ($meal->table->table_number == $value){
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Only one meal per table!';
    }
}
