<?php

namespace Modules\Coupon\Http\Requests\CuApi\V1;

use App\Exceptions\MainException;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Coupon\Repositories\CuApi\V1\CouponRepository;

class CouponRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => 'required|string',
            'order_value' => 'required|numeric'
        ];
    }

    public function passedValidation(): void
    {
        $coupon = new CouponRepository();
        $coupon->check([
            'code' => $this->input('code'),
            'order_value' => $this->input('order_value'),
        ]);
        if (! $coupon->status)
            throw new MainException(false, $coupon->message, 422);
    }

    public function authorize(): bool
    {
        return auth('sanctum')->check();
    }
}
