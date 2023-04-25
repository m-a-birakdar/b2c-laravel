<?php

namespace Modules\User\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|digits_between:10,16|regex:/(00)[0-9]/|unique:users,phone',
            'password' => 'required|min:4|confirmed',
            'name' => 'required|min:4|max:100',
            'fcm_token' => 'required|string',
            'device_info' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
