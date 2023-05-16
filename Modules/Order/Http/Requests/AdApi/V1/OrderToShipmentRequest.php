<?php

namespace Modules\Order\Http\Requests\AdApi\V1;

use Illuminate\Foundation\Http\FormRequest;

class OrderToShipmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_id' => 'required|integer|exists:orders,id',
            'courier_id' => 'required|integer|exists:users,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
