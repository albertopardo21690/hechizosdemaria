@extends('layouts.app')

@php
    $name = $product->attribute_data['name']?->getValue() ?? '-';
    $desc = $product->attribute_data['description']?->getValue() ?? '';
    $variant = $product->variants->first();
    $eurPrice = $variant?->prices->firstWhere('currency.code', 'EUR');
    $usdPrice = $variant?->prices->firstWhere('currency.code', 'USD');
    $media = $product->getMedia('images');
@endphp

@section('title', $name)
@section('meta_description', strip_tags($desc))

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid lg:grid-cols-2 gap-12">

        <div>
            @if($media->count())
                <div class="aspect-square bg-mystic-800/50 border border-gold-500/10 rounded-xl overflow-hidden">
                    <img src="{{ $media->first()->getUrl('large') }}" alt="{{ $name }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="aspect-square bg-mystic-800/50 border border-gold-500/10 rounded-xl flex items-center justify-center text-gold-400/30">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            @endif
        </div>

        <div>
            @if($product->collections->count())
                <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-3">
                    {{ $product->collections->first()->attribute_data['name']?->getValue() ?? '' }}
                </p>
            @endif
            <h1 class="font-heading text-3xl md:text-4xl text-shimmer mb-6">{{ $name }}</h1>

            @if($eurPrice)
                <div class="mb-8">
                    <div class="text-3xl font-semibold text-gold-400">
                        {{ number_format($eurPrice->price->decimal, 2, ',', '.') }} €
                    </div>
                    @if($usdPrice)
                        <div class="text-sm text-gray-500 mt-1">${{ number_format($usdPrice->price->decimal, 2, '.', ',') }} USD</div>
                    @endif
                </div>
            @endif

            @if($desc)
                <div class="prose prose-invert max-w-none text-gray-300 mb-8">
                    {!! $desc !!}
                </div>
            @endif

            <div class="flex flex-wrap gap-4 mb-8">
                <form method="POST" action="#" class="inline-flex">
                    @csrf
                    <input type="hidden" name="variant_id" value="{{ $variant?->id }}">
                    <button type="submit" class="btn-mystic">Anadir al carrito</button>
                </form>
                <a href="https://wa.me/34695619087?text={{ urlencode('Hola Maria, me interesa: '.$name) }}" target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center px-6 py-3 rounded-md font-semibold tracking-wide border border-gold-400/60 text-gold-400 hover:bg-gold-400/10 transition">
                    Consultar por WhatsApp
                </a>
            </div>

            <div class="border-t border-gold-500/10 pt-6 text-sm text-gray-400 space-y-2">
                <p>SKU: {{ $variant?->sku }}</p>
                <p>Envio gratis a partir de 50€ a peninsula</p>
            </div>
        </div>
    </div>

    @if($related->count())
    <div class="mt-20">
        <h2 class="font-heading text-2xl text-center mb-8">Quizas tambien te interese</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related as $product)
                @include('front.partials.product-card')
            @endforeach
        </div>
    </div>
    @endif
</section>
@endsection
