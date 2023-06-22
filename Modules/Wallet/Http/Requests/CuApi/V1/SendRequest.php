<?php

namespace Modules\Wallet\Http\Requests\CuApi\V1;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Repositories\WalletBaseRepository;
use Modules\Wallet\Rules\CuApi\V1\ValidateAmountRule;
use Modules\Wallet\Rules\CuApi\V1\ValidateToRule;

class SendRequest extends FormRequest
{
    public Wallet|null $fromWallet;
    public Wallet|null $toWallet;

    public function prepareForValidation()
    {
        $this->fromWallet = ( new WalletBaseRepository )->findWhere('user_id', sanctum()->id);
        $this->toWallet = ( new WalletBaseRepository )->findByNumber($this->input('to'));
    }

    public function rules(): array
    {
        return [
            'to' => ['required', 'regex:/^\d{4}-\d{4}-\d{4}$/', new ValidateToRule($this->fromWallet, $this->toWallet)],
            'amount' => ['required', 'numeric', new ValidateAmountRule($this->fromWallet)]
        ];
    }

    public function authorize(): bool
    {
        return auth('sanctum')->check();
    }
}
