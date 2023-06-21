<?php

namespace Modules\Product\Http\Requests\AdApi\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => 'nullable|in:0,1',
            'price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'quantity' => 'nullable|integer',
        ];
    }

    public function authorize(): bool
    {
        return auth('sanctum')->check() && sanctum()->hasRole('admin');
    }
}
