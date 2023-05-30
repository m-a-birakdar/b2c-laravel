<?php

namespace Modules\User\Http\Requests\CuApi\V1;

use Illuminate\Foundation\Http\FormRequest;

class WelcomeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fcm_token' => 'required|min:10|max:250',
            'device_info' => 'required|json',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
