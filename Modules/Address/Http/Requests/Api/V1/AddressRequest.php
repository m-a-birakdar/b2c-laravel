<?php

namespace Modules\Address\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:100',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
