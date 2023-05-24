<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Base64Image implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value))
            $fail('The :attribute must be base64.');

        $decoded = base64_decode($value, true);
        if (! $decoded || ! @getimagesizefromstring($decoded))
            $fail('The :attribute must be base64.');
    }
}
