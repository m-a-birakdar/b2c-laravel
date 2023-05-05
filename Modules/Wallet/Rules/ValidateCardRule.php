<?php

namespace Modules\Wallet\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Wallet\Repositories\Api\V1\CardRepository;

class ValidateCardRule implements Rule
{
    public $card;

    public function __construct($card)
    {
        $this->card = $card;
    }

    public function passes($attribute, $value): bool
    {
        return ! is_null($this->card);
    }

    public function message()
    {
        return tr('wallet.this_card_is_not_valid');
    }
}
