<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;
use Illuminate\Support\Facades\Auth;

class DifferentUsername implements Rule
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
        $authedUser = Auth::guard('api')->user();
        $users = User::all();
    
        foreach($users as $user){
            if ($user->id != $authedUser->id && $user->username==$value){
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
        return 'The username has already been taken.';
    }
}
