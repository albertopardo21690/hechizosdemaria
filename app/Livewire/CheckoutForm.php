<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Lunar\Facades\CartSession;
use Lunar\Models\Country;

class CheckoutForm extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|string|max:120')]
    public string $firstName = '';

    #[Validate('required|string|max:120')]
    public string $lastName = '';

    #[Validate('nullable|string|max:120')]
    public string $phone = '';

    #[Validate('required|string|max:255')]
    public string $line1 = '';

    #[Validate('nullable|string|max:255')]
    public string $line2 = '';

    #[Validate('required|string|max:120')]
    public string $city = '';

    #[Validate('nullable|string|max:120')]
    public string $state = '';

    #[Validate('required|string|max:20')]
    public string $postcode = '';

    #[Validate('required|exists:lunar_countries,id')]
    public ?int $countryId = null;

    #[Validate('required|in:stripe,paypal,redsys')]
    public string $paymentMethod = 'stripe';

    public bool $shippingSameAsBilling = true;

    public function mount(): void
    {
        $this->countryId = Country::where('iso2', 'ES')->value('id');
    }

    public function placeOrder()
    {
        $this->validate();

        $cart = CartSession::current();
        if (! $cart || $cart->lines()->count() === 0) {
            session()->flash('checkout_error', 'Tu carrito esta vacio.');

            return redirect()->route('shop');
        }

        $addressData = [
            'country_id' => $this->countryId,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'line_one' => $this->line1,
            'line_two' => $this->line2 ?: null,
            'city' => $this->city,
            'state' => $this->state ?: null,
            'postcode' => $this->postcode,
            'contact_email' => $this->email,
            'contact_phone' => $this->phone ?: null,
        ];

        $cart->addAddress($addressData, 'billing');
        $cart->addAddress($addressData, 'shipping');

        $order = $cart->createOrder();
        $order->update([
            'meta' => array_merge($order->meta?->toArray() ?? [], [
                'payment_method_selected' => $this->paymentMethod,
            ]),
        ]);

        return redirect()->route('payment.start', [
            'gateway' => $this->paymentMethod,
            'reference' => $order->reference,
        ]);
    }

    public function render()
    {
        $cart = CartSession::current();

        return view('livewire.checkout-form', [
            'cart' => $cart,
            'lines' => $cart?->lines()->with('purchasable.product')->get() ?? collect(),
            'countries' => Country::orderBy('name')->get(['id', 'name']),
        ]);
    }
}
