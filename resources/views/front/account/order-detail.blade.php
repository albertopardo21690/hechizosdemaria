@extends('layouts.app')
@section('title', 'Pedido #'.$order->reference)
@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <p class="text-pink-500 text-xs tracking-[0.4em] uppercase mb-1">Mi cuenta</p>
    <h1 class="font-heading text-3xl text-pink-700 mb-8">Pedido #{{ $order->reference }}</h1>

    <div class="grid md:grid-cols-[200px_1fr] gap-8">
        @include('front.account._nav')

        <div class="space-y-6">
            <div class="bg-white border border-pink-200 rounded-xl p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-6">
                    <div><span class="block text-gray-500 text-xs uppercase tracking-widest">Fecha</span>{{ $order->placed_at?->format('d/m/Y H:i') }}</div>
                    <div><span class="block text-gray-500 text-xs uppercase tracking-widest">Estado</span>{{ $order->status }}</div>
                    <div><span class="block text-gray-500 text-xs uppercase tracking-widest">Total</span><strong class="text-pink-700">{{ number_format($order->total->decimal, 2, ',', '.') }} €</strong></div>
                    <div><span class="block text-gray-500 text-xs uppercase tracking-widest">Método</span>{{ $order->meta?->get('payment_method_selected', '—') }}</div>
                </div>
                <h3 class="font-heading text-pink-700 mb-3">Productos</h3>
                <div class="divide-y divide-pink-100">
                    @foreach($order->lines as $line)
                        <div class="flex justify-between py-3 text-sm">
                            <span>{{ $line->description }} @if($line->quantity > 1)× {{ $line->quantity }}@endif</span>
                            <span class="font-semibold">{{ number_format($line->sub_total->decimal, 2, ',', '.') }} €</span>
                        </div>
                    @endforeach
                </div>
                <div class="border-t border-pink-200 pt-3 mt-2 text-sm space-y-1">
                    <div class="flex justify-between"><span class="text-gray-600">Subtotal</span><span>{{ number_format($order->sub_total->decimal, 2, ',', '.') }} €</span></div>
                    <div class="flex justify-between"><span class="text-gray-600">IVA</span><span>{{ number_format($order->tax_total->decimal, 2, ',', '.') }} €</span></div>
                    <div class="flex justify-between font-bold text-pink-700 text-lg pt-2 border-t border-pink-200"><span>Total</span><span>{{ number_format($order->total->decimal, 2, ',', '.') }} €</span></div>
                </div>
            </div>

            @if($order->billingAddress)
                <div class="bg-white border border-pink-200 rounded-xl p-6">
                    <h3 class="font-heading text-pink-700 mb-3">Dirección de facturación</h3>
                    <p class="text-sm text-gray-700">
                        {{ $order->billingAddress->first_name }} {{ $order->billingAddress->last_name }}<br>
                        @if($order->billingAddress->line_one){{ $order->billingAddress->line_one }}<br>@endif
                        @if($order->billingAddress->city){{ $order->billingAddress->postcode }} {{ $order->billingAddress->city }}<br>@endif
                        {{ $order->billingAddress->contact_email }}
                    </p>
                </div>
            @endif

            <a href="{{ route('account.orders') }}" class="text-pink-600 hover:text-pink-800 text-xs uppercase tracking-widest font-semibold">← Volver a pedidos</a>
        </div>
    </div>
</section>
@endsection
