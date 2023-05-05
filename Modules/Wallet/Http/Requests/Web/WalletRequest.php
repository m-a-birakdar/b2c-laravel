<?php

namespace Modules\Wallet\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
