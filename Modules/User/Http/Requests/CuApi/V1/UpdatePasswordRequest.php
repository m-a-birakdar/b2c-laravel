<?php

namespace Modules\User\Http\Requests\CuApi\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|min:4|confirmed',
        ];
    }

    public function authorize(): bool
    {
        return auth()->guard('sanctum')->check();
    }
}
