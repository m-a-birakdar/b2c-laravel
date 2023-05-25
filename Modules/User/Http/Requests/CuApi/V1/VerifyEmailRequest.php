<?php

namespace Modules\User\Http\Requests\CuApi\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\User\Rules\VerifyEmailTokenRule;

class VerifyEmailRequest extends FormRequest
{
    public function rules(): array
    {
        return $this->route()->getActionMethod() == 'verifyEmail' ? [
            'email' => 'nullable|email|' . Rule::exists('users')->where('id', sanctum()->id),
        ] : [
            'token' => ['required', new VerifyEmailTokenRule($this->input('email'))],
            'email' => 'nullable|email|exists:users',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
