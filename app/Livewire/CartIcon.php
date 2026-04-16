<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Lunar\Facades\CartSession;

class CartIcon extends Component
{
    public int $count = 0;

    public function mount(): void
    {
        $this->refresh();
    }

    #[On('cart-updated')]
    public function refresh(): void
    {
        $cart = CartSession::current(calculate: false);
        $this->count = $cart?->lines()->sum('quantity') ?? 0;
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
}
