<?php

namespace Modules\Wallet\Rules\CuApi\V1;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Wallet\Entities\Wallet;

class ValidateAmountRule implements ValidationRule
{
    public function __construct(public Wallet|null $wallet){}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value > $this->wallet->balance)
            $fail('Can\'t send bigger than your balance');
    }
}
