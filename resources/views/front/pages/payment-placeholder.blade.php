@extends('layouts.app')
@section('title', 'Pago - '.$gateway)
@section('content')
<section class="max-w-2xl mx-auto px-4 py-20 text-center">
    <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Pasarela: {{ $gateway }}</p>
    <h1 class="font-heading text-3xl md:text-4xl text-shimmer mb-6">Pedido #{{ $order->reference }}</h1>

    <div class="bg-mystic-800/50 border border-gold-500/10 rounded-2xl p-8 mb-6">
        <div class="text-4xl font-bold text-gold-400 mb-4">
            {{ number_format($order->total->decimal, 2, ',', '.') }} {{ $order->currency_code === 'EUR' ? '€' : '$' }}
        </div>
        <p class="text-gray-400">{{ $message }}</p>
    </div>

    <div class="flex gap-3 justify-center">
        <a href="{{ route('payment.success', $order->reference) }}" class="btn-mystic">Simular exito</a>
        <a href="{{ route('payment.failure', $order->reference) }}" class="inline-flex items-center justify-center px-6 py-3 rounded-md font-semibold tracking-wide border border-gold-400/60 text-gold-400 hover:bg-gold-400/10 transition">Simular fallo</a>
    </div>
</section>
@endsection
