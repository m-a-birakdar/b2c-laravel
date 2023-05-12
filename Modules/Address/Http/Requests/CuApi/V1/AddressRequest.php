<?php

namespace Modules\Address\Http\Requests\CuApi\V1;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'city_id' => 'required|integer|exists:cities,id',
            'address' => 'required|string|max:100',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
