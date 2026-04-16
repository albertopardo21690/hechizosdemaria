<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        app(\Lunar\Base\ShippingModifiers::class)->add(
            \App\Modifiers\StandardShippingModifier::class
        );
    }
}
