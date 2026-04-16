@extends('layouts.app')

@section('title', 'Sobre Maria Jose Gomez')
@section('meta_description', 'Conoce a Maria Jose Gomez, tarotista profesional, astrologa, ritualista y escritora. 15 anos guiando almas a traves del tarot evolutivo, rituales de alta magia, bola de cristal y oraculos.')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden py-20 lg:py-32">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_-20%,rgba(59,7,100,0.5)_0%,transparent_60%)] pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6 order-2 lg:order-1">
                <span class="text-gold-400 text-xs tracking-[0.3em] uppercase block">Sobre mi</span>
                <h1 class="font-heading text-5xl md:text-6xl lg:text-7xl italic text-shimmer leading-[1.05]">Soy Maria Jose</h1>
                <p class="font-heading text-xl md:text-2xl italic text-gold-300/90 max-w-md">Tarotista profesional y guia espiritual</p>
                <p class="text-gray-300 leading-relaxed max-w-lg">
                    Si has llegado a mi no es por casualidad sino por <em class="text-gold-400 not-italic">&laquo;causalidad&raquo;</em>. Creo firmemente en las conexiones energeticas y el tarot no es unicamente una herramienta de prediccion, sino una conexion profunda con el alma y la energia, que nos permite analizar, transformar y tomar decisiones con una vision amplia de la situacion que estas viviendo.
                </p>
                <p class="text-gray-300 leading-relaxed max-w-lg">
                    Ademas del tarot evolutivo tambien utilizo oraculos, lectura con bola de cristal y pendulo, y completamos con trabajos energeticos, rituales de alta magia con mucha fuerza que te llevaran a cumplir tus deseos.
                </p>
                <div class="pt-4 flex flex-wrap gap-4">
                    <a href="{{ route('collection', 'lecturas') }}" class="btn-mystic">Reserva tu lectura</a>
                    <a href="https://wa.me/34695619087" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-6 py-3 rounded-md font-semibold tracking-widest uppercase text-sm border border-gold-400/60 text-gold-400 hover:bg-gold-400/10 transition">
                        Hablar por WhatsApp
                    </a>
                </div>
            </div>

            <div class="relative order-1 lg:order-2">
                <div class="absolute inset-0 bg-gold-400/20 blur-3xl rounded-full"></div>
                <div class="relative aspect-[4/5] rounded-2xl overflow-hidden border border-gold-500/20 bg-gradient-to-br from-purple-900/60 via-mystic-800 to-mystic-950 shadow-2xl">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-64 h-64 text-gold-400/40 animate-pulse" style="animation-duration:6s" fill="none" stroke="currentColor" stroke-width="0.4" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l2.39 7.36H22l-6.18 4.49 2.36 7.36L12 16.72 5.82 21.21l2.36-7.36L2 9.36h7.61z"/>
                        </svg>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-mystic-950 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-center">
                        <span class="text-gold-400 text-xs tracking-[0.4em] uppercase font-heading">Hechizos de Maria</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CREDENCIALES --}}
<section class="py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Mi esencia</p>
            <h2 class="font-heading text-3xl md:text-4xl">Lo que soy</h2>
            <div class="w-24 h-px bg-gold-400 mx-auto mt-4"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="border border-gold-500/20 p-8 rounded-xl text-center space-y-3 bg-mystic-800/30 hover:border-gold-400/60 transition">
                <svg class="w-10 h-10 mx-auto text-gold-400" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2M5.636 5.636l1.414 1.414m9.9 9.9l1.414 1.414M3 12h2m14 0h2M5.636 18.364l1.414-1.414m9.9-9.9l1.414-1.414M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                <h3 class="font-heading text-lg">Astrologa</h3>
            </div>
            <div class="border border-gold-500/20 p-8 rounded-xl text-center space-y-3 bg-mystic-800/30 hover:border-gold-400/60 transition">
                <svg class="w-10 h-10 mx-auto text-gold-400" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                    <rect x="3" y="5" width="8" height="14" rx="1.5"/>
                    <rect x="13" y="5" width="8" height="14" rx="1.5"/>
                    <path stroke-linecap="round" d="M7 9v6M17 9v6"/>
                </svg>
                <h3 class="font-heading text-lg">Maestra del Tarot</h3>
            </div>
            <div class="border border-gold-500/20 p-8 rounded-xl text-center space-y-3 bg-mystic-800/30 hover:border-gold-400/60 transition">
                <svg class="w-10 h-10 mx-auto text-gold-400" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3"/>
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" d="M12 3v2M12 19v2M3 12h2M19 12h2"/>
                </svg>
                <h3 class="font-heading text-lg">Vidente</h3>
            </div>
            <div class="border border-gold-500/20 p-8 rounded-xl text-center space-y-3 bg-mystic-800/30 hover:border-gold-400/60 transition">
                <svg class="w-10 h-10 mx-auto text-gold-400" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-8-4.5-8-11a5 5 0 019-3 5 5 0 019 3c0 6.5-8 11-8 11h-2z"/>
                    <path stroke-linecap="round" d="M12 4v7"/>
                </svg>
                <h3 class="font-heading text-lg">Ritualista</h3>
            </div>
            <div class="border border-gold-500/20 p-8 rounded-xl text-center space-y-3 bg-mystic-800/30 hover:border-gold-400/60 transition">
                <svg class="w-10 h-10 mx-auto text-gold-400" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l6-6 4 4 8-8M21 7h-5M21 7v5"/>
                </svg>
                <h3 class="font-heading text-lg">Escritora</h3>
            </div>
            <div class="border border-gold-500/20 p-8 rounded-xl text-center space-y-3 bg-mystic-800/30 hover:border-gold-400/60 transition">
                <svg class="w-10 h-10 mx-auto text-gold-400" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                    <circle cx="12" cy="6" r="2"/>
                    <path stroke-linecap="round" d="M12 9v5M8 14h8M9 22l3-6 3 6"/>
                </svg>
                <h3 class="font-heading text-lg">Guia de meditacion</h3>
            </div>
        </div>
    </div>
</section>


{{-- CTA FINAL --}}
<section class="py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-heading text-3xl md:text-5xl italic text-shimmer mb-10 leading-tight">
            &iquest;Lista para conectar con tu energia?
        </h2>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('collection', 'lecturas') }}" class="btn-mystic">Ver lecturas</a>
            <a href="https://wa.me/34695619087?text={{ urlencode('Hola Maria, me gustaria reservar una consulta') }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-6 py-3 rounded-md font-semibold tracking-widest uppercase text-sm border border-gold-400/60 text-gold-400 hover:bg-gold-400/10 transition">
                Consultar por WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection
