<?php

namespace App\Livewire;

use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\ProductVariant;

class AddToCart extends Component
{
    public int $variantId;

    public int $quantity = 1;

    public bool $added = false;

    public function mount(int $variantId): void
    {
        $this->variantId = $variantId;
    }

    public function add(): void
    {
        $variant = ProductVariant::find($this->variantId);
        if (! $variant) {
            return;
        }

        $cart = CartSession::current();
        $cart->add($variant, max(1, $this->quantity));

        $this->added = true;
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
