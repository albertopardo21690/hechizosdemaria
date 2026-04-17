@extends('layouts.app')
@section('title', 'Pago por Bizum · Pedido #'.$order->reference)
@section('content')
<section class="max-w-2xl mx-auto px-4 py-16">
    <div class="text-center mb-8">
        <p class="text-pink-500 text-xs tracking-[0.4em] uppercase mb-2">Pago por Bizum</p>
        <h1 class="font-heading text-3xl text-pink-700 mb-3">Instrucciones de pago</h1>
        <p class="text-gray-600">Pedido <span class="font-mono font-bold text-pink-700">#{{ $order->reference }}</span></p>
    </div>

    <div class="bg-white border border-pink-200 rounded-xl p-6 mb-6 space-y-4">
        <div class="text-center">
            <p class="text-4xl font-heading text-pink-700 mb-2">{{ number_format($order->total->decimal, 2, ',', '.') }} €</p>
            <p class="text-sm text-gray-500">Importe total a enviar por Bizum</p>
        </div>
        <hr class="border-pink-100">
        <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-gray-600">Enviar Bizum al número:</span><span class="font-bold text-pink-700 text-lg">695 619 087</span></div>
            <div class="flex justify-between"><span class="text-gray-600">Concepto obligatorio:</span><span class="font-mono font-bold text-pink-700">#{{ $order->reference }}</span></div>
        </div>
        <hr class="border-pink-100">
        <ol class="list-decimal list-inside text-sm text-gray-700 space-y-2">
            <li>Abre tu app del banco o la app de Bizum</li>
            <li>Envía <strong>{{ number_format($order->total->decimal, 2, ',', '.') }} €</strong> al número <strong>695 619 087</strong></li>
            <li>En el concepto escribe: <strong>#{{ $order->reference }}</strong></li>
            <li>Una vez enviado, María José verificará el pago y confirmará tu pedido</li>
        </ol>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-800 mb-6">
        <strong>Importante:</strong> Incluye el número de pedido <code>#{{ $order->reference }}</code> en el concepto del Bizum para que podamos identificar tu pago rápidamente.
    </div>

    <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center mb-6">
        @php
            $waMsg = "Hola, he realizado un Bizum de ".number_format($order->total->decimal, 2, ',', '.')."€ para el pedido *#{$order->reference}*. ¡Gracias!";
            $waUrl = 'https://api.whatsapp.com/send?phone=34695619087&text='.rawurlencode($waMsg);
        @endphp
        <p class="text-sm text-green-700 mb-3">¿Ya has enviado el Bizum? Confirma por WhatsApp:</p>
        <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold text-sm px-5 py-2.5 rounded-lg transition">
            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.82 11.82 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/></svg>
            Confirmar pago por WhatsApp
        </a>
    </div>

    <div class="text-center">
        <a href="{{ route('home') }}" class="text-pink-600 hover:text-pink-800 text-sm font-semibold uppercase tracking-widest">← Volver al inicio</a>
    </div>
</section>
@endsection
