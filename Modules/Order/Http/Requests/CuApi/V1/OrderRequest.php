<?php

namespace Modules\Order\Http\Requests\CuApi\V1;

use App\Exceptions\MainException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Cart\Entities\Cart;
use Modules\Cart\Repositories\CuApi\V1\CartRepository;
use Modules\Order\Enums\OrderPaymentMethodEnum;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Repositories\CuApi\V1\WalletRepository;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address_id' => 'required|integer|exists:addresses,id',
            'coupon_code' => 'nullable|string',
            'payment_method' => 'required|integer|' . Rule::in(array_map('strtolower', array_column(OrderPaymentMethodEnum::cases(), 'value'))),
        ];
    }

    protected function passedValidation()
    {
        $this->getCartInfo();
        if($this->input('payment_method') == OrderPaymentMethodEnum::Wallet->value){
            $this->wallet = (new WalletRepository())->show();
            if ($this->wallet->balance < ($this->cart->shipping_amount + $this->totalPriceAmount)){
                throw new MainException(false, tr('order.check_your_wallet'), 422);
            }
        }
    }

    public Cart $cart;
    public Wallet $wallet;
    public int $totalPriceAmount = 0, $totalDiscountAmount = 0;
    public array $orderItems = [];

    public function getCartInfo()
    {
        $this->cart = ( new CartRepository )->findWhere('user_id', sanctum()->id, [
            'products:id,price,discount'
        ]);
        $this->orderItems = [];
        foreach ($this->cart->products as $product) {
            $totalPrice = $product->pivot->quantity * $product->price;
            $totalDiscount = $product->pivot->quantity * $product->discount;
            $this->totalPriceAmount += $totalPrice;
            $this->totalDiscountAmount += $totalDiscount;
            $this->orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $product->pivot->quantity,
                'price' => $product->price,
                'total_price' => $totalPrice,
                'discount' => $totalDiscount,
            ];
        }
    }

    public function authorize(): bool
    {
        return true;
    }
}
