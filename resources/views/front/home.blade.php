@extends('layouts.app')

@section('title', 'Hechizos de Maria - Tarot, rituales y magia blanca')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-purple-900/40 via-transparent to-mystic-950/60 pointer-events-none"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-4">Tarot profesional</p>
                <h1 class="font-heading text-4xl md:text-6xl mb-6 leading-tight">
                    Soy <span class="text-shimmer">Maria Jose</span>,<br>
                    guia espiritual y tarotista
                </h1>
                <p class="text-lg text-gray-300 mb-8 max-w-xl">
                    Lecturas de tarot, rituales personalizados de alta magia y una tienda magica con perfumes arabes, amuletos y cuarzos. Conexion energetica autentica.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('collection', 'lecturas') }}" class="btn-mystic">Reserva tu lectura</a>
                    <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-md font-semibold tracking-wide border border-gold-400/60 text-gold-400 hover:bg-gold-400/10 transition">
                        Ver la tienda
                    </a>
                </div>
            </div>
            <div class="hidden lg:block relative">
                <div class="absolute inset-0 bg-gold-400/20 blur-3xl rounded-full"></div>
                <div class="relative aspect-square rounded-full border border-gold-400/30 bg-gradient-to-br from-purple-800/30 to-mystic-900/50 flex items-center justify-center">
                    <svg class="w-32 h-32 text-gold-400/70" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2M5.636 5.636l1.414 1.414m9.9 9.9l1.414 1.414M3 12h2m14 0h2M5.636 18.364l1.414-1.414m9.9-9.9l1.414-1.414M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LECTURAS --}}
@if($lecturas->count())
<section class="py-20 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Consultas personalizadas</p>
            <h2 class="font-heading text-3xl md:text-4xl">Lecturas de tarot</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($lecturas as $product)
                @include('front.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- RITUALES BANNER --}}
<section class="py-20 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center bg-gradient-to-br from-purple-900/40 to-mystic-800/60 border border-gold-500/20 rounded-2xl p-10 lg:p-16">
            <div>
                <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Alta magia</p>
                <h2 class="font-heading text-3xl md:text-4xl mb-4">Rituales personalizados</h2>
                <p class="text-gray-300 mb-6">Cada ritual se adapta a tu situacion particular. Amor, proteccion, prosperidad, limpieza energetica. Magia blanca con intencion real.</p>
                <a href="{{ route('collection', 'rituales') }}" class="btn-mystic">Descubre los rituales</a>
            </div>
            <div class="hidden lg:block text-center">
                <svg class="w-48 h-48 mx-auto text-gold-400/80" fill="none" stroke="currentColor" stroke-width="0.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0-4v-6m0 0l-3 3m3-3l3 3M8 9l4-4 4 4"/>
                </svg>
            </div>
        </div>
    </div>
</section>

{{-- TIENDA DESTACADOS --}}
@if($destacados->count())
<section class="py-20 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12">
            <div>
                <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Tienda magica</p>
                <h2 class="font-heading text-3xl md:text-4xl">Productos destacados</h2>
            </div>
            <a href="{{ route('shop') }}" class="hidden md:inline-block text-gold-400 hover:text-gold-300 text-sm tracking-widest uppercase">Ver toda la tienda &rarr;</a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($destacados as $product)
                @include('front.partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="text-center mt-8 text-sm text-gold-400/80">Envio gratis a partir de 50€</div>
    </div>
</section>
@endif

{{-- TESTIMONIOS --}}
@if($testimonials->count())
<section class="py-20 bg-mystic-950/60 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Experiencias reales</p>
            <h2 class="font-heading text-3xl md:text-4xl">Lo que dicen los consultantes</h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $t)
                <div class="bg-mystic-800/50 border border-gold-500/10 rounded-xl p-6">
                    <div class="flex text-gold-400 mb-3 text-lg">
                        {!! str_repeat('&#9733;', $t->rating) !!}
                    </div>
                    <p class="text-gray-300 mb-4 italic">"{{ $t->text }}"</p>
                    <div class="text-sm">
                        <div class="font-semibold text-gold-400">{{ $t->name }}</div>
                        @if($t->location)<div class="text-gray-500">{{ $t->location }}</div>@endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
