<?php

namespace App\Modifiers;

use Closure;
use Lunar\Base\ShippingModifier;
use Lunar\DataTypes\Price;
use Lunar\DataTypes\ShippingOption;
use Lunar\Facades\ShippingManifest;
use Lunar\Models\Cart;
use Lunar\Models\Currency;
use Lunar\Models\TaxClass;

class StandardShippingModifier extends ShippingModifier
{
    public const FREE_THRESHOLD_EUR = 50_00;

    public const FLAT_RATE_EUR = 4_90;

    public function handle(Cart $cart, Closure $next)
    {
        $currency = $cart->currency ?? Currency::getDefault();
        $taxClass = TaxClass::where('default', true)->first() ?? TaxClass::first();

        $subTotal = $cart->subTotal?->value ?? 0;

        $priceValue = $subTotal >= self::FREE_THRESHOLD_EUR ? 0 : self::FLAT_RATE_EUR;

        $shipping = new ShippingOption(
            name: $priceValue === 0 ? 'Envio gratis (peninsula)' : 'Envio estandar (peninsula)',
            description: $priceValue === 0 ? 'Pedidos desde 50 EUR' : 'Tarifa plana',
            identifier: 'standard',
            price: new Price($priceValue, $currency, 1),
            taxClass: $taxClass,
        );

        ShippingManifest::addOption($shipping);

        return $next($cart);
    }
}
