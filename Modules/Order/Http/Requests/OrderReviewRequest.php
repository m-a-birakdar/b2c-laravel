<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderReviewRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_id'  => 'required|integer|exists:orders,id',
            'rating'    => 'required|integer|in:1,2,3,4,5',
            'comment'   => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return auth()->guard('sanctum')->check();
    }
}
