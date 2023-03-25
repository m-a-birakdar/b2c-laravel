<?php

namespace Modules\Advertise\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class AdvertiseRequest extends FormRequest
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
