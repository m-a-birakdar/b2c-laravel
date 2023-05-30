<?php

namespace Modules\User\Http\Requests\CuApi\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:users',
            'phone' => 'required|digits_between:10,16|regex:/(00)[0-9]/|unique:users,phone',
            'password' => 'required|min:4|confirmed',
            'name' => 'required|min:4|max:100',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
