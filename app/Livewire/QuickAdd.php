<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\ProductVariant;

class QuickAdd extends Component
{
    public bool $show = false;

    public string $productName = '';

    #[On('quick-add')]
    public function add(int $variantId): void
    {
        $variant = ProductVariant::with('product')->find($variantId);
        if (! $variant) {
            return;
        }

        $cart = CartSession::current();
        $cart->add($variant, 1);

        $this->productName = $variant->product?->attribute_data['name']?->getValue() ?? '';
        $this->show = true;
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.quick-add');
    }
}
