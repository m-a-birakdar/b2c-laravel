<?php

namespace Modules\Wallet\Rules\CuApi\V1;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Wallet\Entities\Wallet;

class ValidateToRule implements ValidationRule
{
    public function __construct(
        public Wallet|null $fromWallet,
        public Wallet|null $toWallet,
    ){}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($this->fromWallet)){
            $fail('You not have a wallet');
        } else {
            if (! $this->fromWallet->status)
                $fail('Your wallet is disabled');
            if (! $this->fromWallet->allow_send)
                $fail('You not allow to send');
        }
        if (is_null($this->toWallet)){
            $fail('This number is not valid');
        } else {
            if ($this->toWallet->user_id == sanctum()->id)
                $fail('Can\'t send to yourself');
            if (! $this->toWallet->status)
                $fail('Receiver wallet is disabled');
            if (! $this->toWallet->allow_receive)
                $fail('Receiver isn\'t allow to receive');
        }

    }
}
