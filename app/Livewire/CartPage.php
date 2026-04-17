<?php

namespace App\Livewire;

use App\Models\Coupon;
use Livewire\Component;
use Lunar\Facades\CartSession;

class CartPage extends Component
{
    public string $couponCode = '';

    public ?string $couponMessage = null;

    public ?string $couponError = null;

    public ?float $couponDiscount = null;

    public function applyCoupon(): void
    {
        $this->couponMessage = null;
        $this->couponError = null;
        $this->couponDiscount = null;

        $code = strtolower(trim($this->couponCode));
        if ($code === '') {
            $this->couponError = 'Introduce un código de cupón.';

            return;
        }

        $coupon = Coupon::findByCode($code);
        if (! $coupon) {
            $this->couponError = 'Cupón no encontrado.';

            return;
        }

        $cart = CartSession::current();
        $cartTotal = $cart ? (float) $cart->subTotal?->decimal : 0;

        if (! $coupon->isValid($cartTotal)) {
            $this->couponError = 'Este cupón ha expirado o no es válido para tu carrito.';

            return;
        }

        $discount = $coupon->discount($cartTotal);
        $this->couponDiscount = $discount;
        $this->couponMessage = $coupon->type === 'percent'
            ? "Cupón «{$coupon->code}» aplicado: -{$coupon->amount}%"
            : "Cupón «{$coupon->code}» aplicado: -{$discount}€";

        session(['applied_coupon' => $coupon->code]);
    }

    public function removeCoupon(): void
    {
        $this->couponCode = '';
        $this->couponMessage = null;
        $this->couponError = null;
        $this->couponDiscount = null;
        session()->forget('applied_coupon');
    }

    public function updateQuantity(int $lineId, int $quantity): void
    {
        $cart = CartSession::current();
        if ($quantity <= 0) {
            $cart->remove($lineId);
        } else {
            $cart->updateLine($lineId, $quantity);
        }
        $this->dispatch('cart-updated');
    }

    public function remove(int $lineId): void
    {
        CartSession::current()->remove($lineId);
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        $cart = CartSession::current();

        return view('livewire.cart-page', [
            'cart' => $cart,
            'lines' => $cart?->lines ?? collect(),
        ]);
    }
}
