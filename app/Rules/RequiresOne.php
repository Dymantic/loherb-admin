<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RequiresOne implements Rule
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


    public function passes($attribute, $value)
    {
        if(!is_array($value)) {
            return false;
        }
        return collect($value)->filter(function($item) {
            return !empty($item);
        })->count() > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'At least one item of the :attribute array is required';
    }
}
