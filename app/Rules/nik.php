<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class nik implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function passes($attribute, $value)
    {
        // Replace this with your actual NIK validation logic
        return preg_match('/^[0-9]{16}$/', $value); // Example: NIK should be a 16-digit number
    }

    public function message()
    {
        return 'The :attribute is invalid.';
    }
}