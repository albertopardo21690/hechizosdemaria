@extends('layouts.app')
@section('title', 'Pedido confirmado')
@section('content')
@php
    $lines = $order->lines ?? collect();
    $productNames = $lines->map(fn($l) => $l->description)->filter()->implode(', ');
    $billingName = $order->billingAddress?->first_name ?? '';
    $billingFullName = trim(($order->billingAddress?->first_name ?? '').' '.($order->billingAddress?->last_name ?? ''));
    $isDigital = $lines->contains(fn($l) => str_contains(strtolower($l->description ?? ''), 'grimorio')
        || str_contains(strtolower($l->description ?? ''), 'libro')
        || str_contains(strtolower($l->meta?->get('downloadable') ?? ''), 'yes'));

    $waMsg = "Hola, soy *{$billingFullName}*.\n"
           . "He comprado: *{$productNames}*.\n"
           . "Pedido: *#{$order->reference}*.\n"
           . "Quiero realizar mi lectura, por favor.";
    $waUrl = 'https://api.whatsapp.com/send?phone=34695619087&text='.rawurlencode($waMsg);
@endphp
<section class="max-w-3xl mx-auto px-4 py-16">
    <div class="text-center mb-10">
        <div class="mx-auto w-20 h-20 rounded-full bg-green-100 border border-green-300 flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <p class="text-pink-500 text-xs tracking-[0.4em] uppercase mb-2">¡Gracias, {{ $billingName }}!</p>
        <h1 class="font-heading text-3xl md:text-4xl text-pink-700 mb-3">Tu pedido está confirmado</h1>
        <p class="text-gray-600">Referencia: <span class="font-mono text-pink-700 font-bold">#{{ $order->reference }}</span></p>
    </div>

    {{-- DETALLES DEL PEDIDO --}}
    <div class="bg-white border border-pink-200 rounded-xl p-6 mb-6">
        <h2 class="font-heading text-lg text-pink-700 mb-4">Resumen del pedido</h2>
        <div class="divide-y divide-pink-100">
            @foreach($lines as $line)
                <div class="flex justify-between py-3 text-sm">
                    <div>
                        <span class="text-gray-800 font-semibold">{{ $line->description }}</span>
                        @if($line->quantity > 1)<span class="text-gray-500"> × {{ $line->quantity }}</span>@endif
                    </div>
                    <span class="font-semibold text-gray-800">{{ number_format($line->sub_total->decimal, 2, ',', '.') }} €</span>
                </div>
            @endforeach
        </div>
        <div class="border-t border-pink-200 pt-3 mt-2 space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-gray-600">Subtotal</span><span>{{ number_format($order->sub_total->decimal, 2, ',', '.') }} €</span></div>
            @if($order->shipping_total?->decimal > 0)
                <div class="flex justify-between"><span class="text-gray-600">Envío</span><span>{{ number_format($order->shipping_total->decimal, 2, ',', '.') }} €</span></div>
            @endif
            <div class="flex justify-between"><span class="text-gray-600">IVA (21%)</span><span>{{ number_format($order->tax_total->decimal, 2, ',', '.') }} €</span></div>
            <div class="flex justify-between text-lg font-bold text-pink-700 pt-2 border-t border-pink-200">
                <span>Total</span>
                <span>{{ number_format($order->total->decimal, 2, ',', '.') }} €</span>
            </div>
        </div>
    </div>

    {{-- WHATSAPP CTA --}}
    <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center mb-6">
        <h2 class="font-heading text-xl text-green-800 mb-2">Siguiente paso: contacta con María José</h2>
        <p class="text-sm text-green-700 mb-4">Para lecturas y servicios personalizados, envíale un mensaje por WhatsApp con los datos de tu pedido. El mensaje está pre-rellenado.</p>
        <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-3 bg-green-500 hover:bg-green-600 text-white font-bold uppercase tracking-widest text-sm px-8 py-4 rounded-xl transition shadow-lg hover:shadow-xl">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.82 11.82 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/></svg>
            Escribir a María José por WhatsApp
        </a>
        <p class="text-xs text-green-600 mt-3">+34 695 619 087 · Responde en menos de 24 horas</p>
    </div>

    {{-- DESCARGAS DIGITALES (si aplica) --}}
    @if($isDigital)
        <div class="bg-pink-50 border border-pink-200 rounded-xl p-6 mb-6">
            <h2 class="font-heading text-lg text-pink-700 mb-3">Tus descargas</h2>
            <p class="text-sm text-gray-600 mb-4">Los archivos digitales de tu pedido están disponibles para descargar.</p>
            @foreach($lines as $line)
                @php $downloadUrl = $line->meta?->get('download_url'); @endphp
                @if($downloadUrl)
                    <a href="{{ $downloadUrl }}" target="_blank" class="flex items-center gap-3 p-3 bg-white border border-pink-200 rounded-lg hover:border-pink-400 transition mb-2">
                        <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        <div>
                            <p class="text-sm font-semibold text-pink-700">{{ $line->description }}</p>
                            <p class="text-xs text-gray-500">Click para descargar PDF</p>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    @endif

    <div class="text-center space-y-3">
        <p class="text-sm text-gray-500">Hemos enviado una confirmación a tu email con todos los detalles.</p>
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('shop') }}" class="bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 text-white font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-md transition">Seguir comprando</a>
            <a href="{{ route('home') }}" class="border border-pink-300 text-pink-600 hover:bg-pink-50 font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-md transition">Volver al inicio</a>
        </div>
    </div>
</section>
@endsection
