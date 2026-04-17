<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lunar\Models\Order;

class PaymentController extends Controller
{
    public function start(Request $request, string $gateway, string $reference)
    {
        $order = Order::where('reference', $reference)->firstOrFail();

        return match ($gateway) {
            'stripe' => $this->startStripe($order),
            'paypal' => $this->startPaypal($order),
            'redsys' => $this->startRedsys($order),
            'bizum' => $this->startBizum($order),
            default => abort(404),
        };
    }

    public function success(string $reference)
    {
        $order = Order::where('reference', $reference)->firstOrFail();

        return view('front.pages.order-success', compact('order'));
    }

    public function failure(string $reference)
    {
        $order = Order::where('reference', $reference)->firstOrFail();

        return view('front.pages.order-failure', compact('order'));
    }

    protected function startStripe(Order $order)
    {
        return view('front.pages.payment-placeholder', [
            'order' => $order,
            'gateway' => 'Stripe',
            'message' => 'La integracion con Stripe se activa en Fase 5.3.',
        ]);
    }

    protected function startPaypal(Order $order)
    {
        return view('front.pages.payment-placeholder', [
            'order' => $order,
            'gateway' => 'PayPal',
            'message' => 'La integracion con PayPal se activa en Fase 5.4.',
        ]);
    }

    protected function startRedsys(Order $order)
    {
        return view('front.pages.payment-placeholder', [
            'order' => $order,
            'gateway' => 'Redsys',
            'message' => 'La integracion con Redsys se activa en Fase 5.5.',
        ]);
    }

    protected function startBizum(Order $order)
    {
        $order->update(['status' => 'awaiting-payment']);

        return view('front.pages.bizum-instructions', compact('order'));
    }
}
