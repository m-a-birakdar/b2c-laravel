<?php

namespace Modules\Currency\Http\Requests\AdApi\V1;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'value' => 'required|numeric'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
