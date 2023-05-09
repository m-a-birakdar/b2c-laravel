<?php

namespace Modules\User\Http\Requests\CuApi\V1;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
