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
                <div class="aspect-square relative bg-gradient-to-br from-purple-900/60 via-mystic-800 to-mystic-950 border border-gold-500/20 rounded-xl overflow-hidden flex items-center justify-center">
                    <div class="absolute inset-0 opacity-20" style="background: radial-gradient(circle at center, #d4a853 0%, transparent 60%);"></div>
                    <svg class="relative w-48 h-48 text-gold-400/70 animate-pulse" style="animation-duration:5s" fill="none" stroke="currentColor" stroke-width="0.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l2.39 7.36H22l-6.18 4.49 2.36 7.36L12 16.72 5.82 21.21l2.36-7.36L2 9.36h7.61z"/>
                    </svg>
                    <span class="absolute bottom-6 left-0 right-0 text-center text-gold-400/60 text-[10px] uppercase tracking-[0.4em] font-heading">Ritual consagrado</span>
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
                <div class="prose prose-invert max-w-none text-gray-700 mb-8">
                    {!! $desc !!}
                </div>
            @endif

            <div class="flex flex-wrap gap-4 mb-8">
                @if($variant)
                    <livewire:add-to-cart :variantId="$variant->id" />
                @endif
                <a href="https://wa.me/34695619087?text={{ urlencode('Hola Maria, me interesa: '.$name) }}" target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center px-6 py-3 rounded-md font-semibold tracking-wide border border-gold-400/60 text-gold-400 hover:bg-gold-400/10 transition">
                    Consultar por WhatsApp
                </a>
            </div>

            <div class="border-t border-gold-500/10 pt-6 text-sm text-gray-600 space-y-2">
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
