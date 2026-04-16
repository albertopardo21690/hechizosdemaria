<?php

namespace App\Livewire;

use Livewire\Component;
use Lunar\Facades\CartSession;

class CartPage extends Component
{
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
