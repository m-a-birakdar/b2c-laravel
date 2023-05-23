<?php

namespace Modules\User\Http\Requests\CuApi\V1;

use Illuminate\Foundation\Http\FormRequest;

class SendOTPRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|digits_between:10,16|regex:/(00)[0-9]/',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
