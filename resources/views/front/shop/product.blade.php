@extends('layouts.app')

@php
    $name = $product->attribute_data['name']?->getValue() ?? '-';
    $desc = $product->attribute_data['description']?->getValue() ?? '';
    $variant = $product->variants->first();
    $eurPrice = $variant?->prices->firstWhere('currency.code', 'EUR');
    $usdPrice = $variant?->prices->firstWhere('currency.code', 'USD');
    $media = $product->getMedia('images');
    $collection = $product->collections->first();
    $collectionName = $collection?->attribute_data['name']?->getValue();
    $collectionSlug = $collection?->urls?->where('default', true)->first()?->slug ?? $collection?->urls?->first()?->slug;
@endphp

@section('title', $name)
@section('meta_description', strip_tags($desc))

@section('content')
@if(! empty($productTemplate) && $productTemplate->hasBlocks())
    @foreach($productTemplate->sectionsNormalized() as $section)
        @include('front.sections.wrapper', ['section' => $section, 'product' => $product])
    @endforeach
@else
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumbs --}}
    <nav class="flex items-center gap-2 text-xs text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-pink-500 transition">Inicio</a>
        <span>/</span>
        <a href="{{ route('shop') }}" class="hover:text-pink-500 transition">Tienda</a>
        @if($collectionName && $collectionSlug)
            <span>/</span>
            <a href="{{ route('collection', $collectionSlug) }}" class="hover:text-pink-500 transition">{{ $collectionName }}</a>
        @endif
        <span>/</span>
        <span class="text-gray-600">{{ $name }}</span>
    </nav>

    <div class="grid lg:grid-cols-2 gap-12 items-start">

        {{-- Gallery --}}
        <div x-data="{ active: 0 }" class="space-y-4">
            {{-- Main image --}}
            <div class="aspect-square bg-pink-50 rounded-2xl overflow-hidden border border-pink-100">
                @if($media->count())
                    @foreach($media as $i => $img)
                        <img x-show="active === {{ $i }}"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             src="{{ $img->getUrl('large') }}" alt="{{ $name }}"
                             class="w-full h-full object-cover">
                    @endforeach
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-pink-300">
                        <svg class="w-24 h-24 mb-3 opacity-50" fill="none" stroke="currentColor" stroke-width="0.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/>
                        </svg>
                        <span class="text-xs uppercase tracking-[0.3em] font-heading text-pink-400">Hechizos de María</span>
                    </div>
                @endif
            </div>

            {{-- Thumbnails --}}
            @if($media->count() > 1)
                <div class="flex gap-3 overflow-x-auto pb-1">
                    @foreach($media as $i => $img)
                        <button @click="active = {{ $i }}"
                                :class="active === {{ $i }} ? 'ring-2 ring-pink-500 ring-offset-2' : 'opacity-60 hover:opacity-100'"
                                class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden border border-pink-100 transition-all">
                            <img src="{{ $img->getUrl('small') }}" alt="" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Product info --}}
        <div class="lg:sticky lg:top-28">
            @if($collectionName)
                <a href="{{ $collectionSlug ? route('collection', $collectionSlug) : '#' }}"
                   class="inline-block text-[10px] uppercase tracking-[0.3em] text-pink-400 font-semibold mb-2 hover:text-pink-600 transition">{{ $collectionName }}</a>
            @endif

            <h1 class="font-heading text-3xl md:text-4xl text-pink-800 mb-4 leading-tight">{{ $name }}</h1>

            @if($eurPrice)
                <div class="flex items-baseline gap-3 mb-6">
                    <span class="text-3xl font-bold text-pink-600">{{ number_format($eurPrice->price->decimal, 2, ',', '.') }} €</span>
                    @if($usdPrice)
                        <span class="text-sm text-gray-400">${{ number_format($usdPrice->price->decimal, 2, '.', ',') }} USD</span>
                    @endif
                </div>
            @endif

            {{-- Short description (first paragraph) --}}
            @if($desc)
                @php $shortDesc = \Illuminate\Support\Str::limit(strip_tags($desc), 200); @endphp
                <p class="text-gray-600 leading-relaxed mb-6">{{ $shortDesc }}</p>
            @endif

            {{-- Add to cart --}}
            <div class="flex flex-wrap gap-3 mb-6">
                @if($variant)
                    <livewire:add-to-cart :variantId="$variant->id" />
                @endif
                <a href="https://wa.me/34695619087?text={{ urlencode('Hola María José, me interesa: '.$name) }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-sm border-2 border-green-400 text-green-600 hover:bg-green-50 transition">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.82 11.82 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/></svg>
                    Consultar
                </a>
            </div>

            {{-- Trust badges --}}
            <div class="flex flex-wrap gap-4 text-xs text-gray-500 mb-8 pb-8 border-b border-pink-100">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                    Envío gratis +50€
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    Pago seguro
                </span>
                @if($variant?->sku)
                    <span class="flex items-center gap-1.5">SKU: {{ $variant->sku }}</span>
                @endif
            </div>

            {{-- Tabs --}}
            <div x-data="{ tab: 'desc' }" class="space-y-4">
                <div class="flex gap-1 border-b border-pink-100">
                    <button @click="tab = 'desc'" :class="tab === 'desc' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-400 hover:text-gray-600'"
                            class="px-4 py-2.5 text-xs font-bold uppercase tracking-widest border-b-2 transition">Descripción</button>
                    <button @click="tab = 'details'" :class="tab === 'details' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-400 hover:text-gray-600'"
                            class="px-4 py-2.5 text-xs font-bold uppercase tracking-widest border-b-2 transition">Detalles</button>
                    <button @click="tab = 'shipping'" :class="tab === 'shipping' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-400 hover:text-gray-600'"
                            class="px-4 py-2.5 text-xs font-bold uppercase tracking-widest border-b-2 transition">Envío</button>
                </div>

                {{-- Description tab --}}
                <div x-show="tab === 'desc'" x-transition>
                    @if($desc)
                        <div class="prose prose-pink max-w-none text-gray-600 text-sm leading-relaxed">
                            {!! $desc !!}
                        </div>
                    @else
                        <p class="text-sm text-gray-400 italic">Sin descripción disponible.</p>
                    @endif
                </div>

                {{-- Details tab --}}
                <div x-show="tab === 'details'" x-transition x-cloak>
                    <dl class="text-sm space-y-3">
                        @if($variant?->sku)
                            <div class="flex justify-between py-2 border-b border-pink-50">
                                <dt class="text-gray-500">Referencia</dt>
                                <dd class="font-semibold text-gray-700">{{ $variant->sku }}</dd>
                            </div>
                        @endif
                        @if($collectionName)
                            <div class="flex justify-between py-2 border-b border-pink-50">
                                <dt class="text-gray-500">Categoría</dt>
                                <dd class="font-semibold text-gray-700">{{ $collectionName }}</dd>
                            </div>
                        @endif
                        <div class="flex justify-between py-2 border-b border-pink-50">
                            <dt class="text-gray-500">Disponibilidad</dt>
                            <dd class="font-semibold {{ ($variant?->stock ?? 0) > 0 ? 'text-green-600' : 'text-pink-600' }}">
                                {{ ($variant?->stock ?? 0) > 0 ? 'En stock' : 'Bajo pedido' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Shipping tab --}}
                <div x-show="tab === 'shipping'" x-transition x-cloak>
                    <div class="text-sm text-gray-600 space-y-3">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-pink-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                            <div>
                                <p class="font-semibold text-gray-700">Península: 4,90€</p>
                                <p class="text-gray-500">Gratis a partir de 50€. Entrega 3-5 días laborables.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-pink-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                            <div>
                                <p class="font-semibold text-gray-700">Internacional: consultar</p>
                                <p class="text-gray-500">Escríbenos por WhatsApp para envíos fuera de España.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-pink-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            <div>
                                <p class="font-semibold text-gray-700">Pagos seguros</p>
                                <p class="text-gray-500">Visa, Mastercard, PayPal y Bizum.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Related products --}}
    @if($related->count())
    <div class="mt-20 pt-12 border-t border-pink-100">
        <div class="text-center mb-10">
            <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-2">También te puede interesar</p>
            <h2 class="font-heading text-2xl md:text-3xl text-pink-700">Productos relacionados</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related as $product)
                @include('front.partials.product-card')
            @endforeach
        </div>
    </div>
    @endif
</section>
@endif
@endsection
