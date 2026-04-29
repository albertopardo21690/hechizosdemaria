@extends('layouts.app')
@section('title', 'Pago fallido')
@section('content')
<section class="max-w-2xl mx-auto px-4 py-20 text-center">
    <div class="mx-auto w-20 h-20 rounded-full bg-red-500/20 border border-red-400/40 flex items-center justify-center mb-6">
        <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
    </div>
    <h1 class="font-heading text-3xl md:text-4xl text-shimmer mb-4">No se pudo completar el pago</h1>
    <p class="text-gray-600 mb-6">Pedido {{ $order->reference }}</p>
    <p class="text-gray-500 text-sm mb-8">No se ha realizado ningun cargo. Puedes intentarlo de nuevo o contactar con nosotros por WhatsApp.</p>
    <div class="flex gap-3 justify-center flex-wrap">
        <a href="{{ route('checkout') }}" class="btn-mystic">Reintentar</a>
        <a href="https://wa.me/34695619087" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-6 py-3 rounded-md font-semibold tracking-wide border border-pink-300 text-pink-500 hover:bg-pink-50 transition">Contactar WhatsApp</a>
    </div>
</section>
@endsection
