@extends('layouts.app')
@section('title', 'Pedido confirmado')
@section('content')
<section class="max-w-2xl mx-auto px-4 py-20 text-center">
    <div class="mx-auto w-20 h-20 rounded-full bg-green-500/20 border border-green-400/40 flex items-center justify-center mb-6">
        <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
    </div>
    <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Gracias</p>
    <h1 class="font-heading text-3xl md:text-4xl text-shimmer mb-4">Tu pedido esta confirmado</h1>
    <p class="text-gray-400 mb-6">Referencia: <span class="text-white font-mono">{{ $order->reference }}</span></p>

    <div class="bg-mystic-800/50 border border-gold-500/10 rounded-2xl p-6 text-left mb-6">
        <div class="flex justify-between mb-3"><span class="text-gray-400">Estado</span><span class="text-gold-400">{{ $order->status }}</span></div>
        <div class="flex justify-between mb-3"><span class="text-gray-400">Total</span><span class="font-bold">{{ number_format($order->total->decimal, 2, ',', '.') }} {{ $order->currency_code === 'EUR' ? '€' : '$' }}</span></div>
        <div class="flex justify-between"><span class="text-gray-400">Fecha</span><span>{{ $order->placed_at?->format('d/m/Y H:i') }}</span></div>
    </div>

    <p class="text-gray-500 text-sm mb-6">Hemos enviado una confirmacion a tu email. Maria Jose se pondra en contacto contigo muy pronto.</p>
    <a href="{{ route('shop') }}" class="btn-mystic">Seguir explorando</a>
</section>
@endsection
