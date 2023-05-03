<?php

namespace Modules\Category\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'status' => 'required|integer|in:0,1',
            'rank' => 'required|integer|max:100',
            'parent_id' => 'nullable|integer|exists:categories,id',
        ];
        if ($this->route()->getActionMethod() == 'POST'){
            $rules['name'] = 'required|string|max:200|unique:categories';
            $rules['image_file'] = 'required|file|mimes:png,jpg';
        } else {
            $rules['name'] = 'required|string|max:200|' . Rule::unique('categories', 'name')->ignore($this->category);
            $rules['image_file'] = 'nullable|file|mimes:png,jpg';
        }
        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
