<?php

namespace Modules\Product\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'city_id' => 'required|integer|exists:cities,id',
            'category_id' => 'required|integer|exists:categories,id',
            'title' => 'required|string|max:200',
            'image_file' => 'required|image|max:1024|mimes:jpg,png,jpeg',
            'status' => 'required|in:0,1',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'rank' => 'required|integer',
            'description' => 'required|string|max:1000',
            'quantity' => 'required|integer',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
