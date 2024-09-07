<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Time12HourFormat implements Rule
{
    public function passes($attribute, $value)
    {
        // Regex to match 12-hour time format with optional AM/PM
        return preg_match('/^(0?[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$/i', $value);
    }

    public function message()
    {
        return 'The :attribute must be a valid 12-hour time format (e.g., 12:00 PM).';
    }
}
