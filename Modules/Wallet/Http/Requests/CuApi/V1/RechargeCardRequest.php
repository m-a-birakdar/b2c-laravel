<?php

namespace Modules\Wallet\Http\Requests\CuApi\V1;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Wallet\Entities\Card;
use Modules\Wallet\Repositories\CuApi\V1\CardRepository;
use Modules\Wallet\Rules\ValidateCardRule;

class RechargeCardRequest extends FormRequest
{
    public Card|null $card;

    public function rules(): array
    {
        return [
            'card_number'   => ['required', 'numeric', 'digits_between:16,16', new ValidateCardRule($this->card)],
            'card_cvv'      => 'required|numeric|digits_between:3,3',
        ];
    }

    protected function prepareForValidation()
    {
        $this->card = ( new CardRepository() )->get($this->input('card_number'), $this->input('card_cvv'));
    }

    public function authorize(): bool
    {
        return true;
    }
}
