<?php

namespace Modules\Tag\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
