@extends('layouts.app')

@section('title', 'Sobre María José Gómez — Hechizos de María')
@section('meta_description', 'Conoce a María José Gómez: tarotista profesional, astróloga, ritualista y escritora. Más de 15 años guiando almas a través del tarot evolutivo, la bola de cristal, los oráculos y rituales de alta magia blanca.')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden bg-gradient-to-br from-pink-50 via-white to-pink-100 py-20 lg:py-28">
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute top-20 right-10 w-96 h-96 bg-pink-200/30 rounded-full blur-3xl animate-pulse" style="animation-duration:8s"></div>
        <div class="absolute bottom-20 left-10 w-80 h-80 bg-pink-100/50 rounded-full blur-3xl animate-pulse" style="animation-duration:6s"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6 order-2 lg:order-1">
                <span class="text-pink-400 text-xs tracking-[0.4em] uppercase block">Sobre mí</span>
                <h1 class="font-heading text-5xl md:text-6xl lg:text-7xl text-pink-800 leading-[1.05]">
                    Soy <span class="italic text-pink-500">María José</span>
                </h1>
                <p class="font-heading text-xl md:text-2xl italic text-pink-600 max-w-md">Tarotista profesional y guía espiritual</p>
                <p class="text-gray-700 leading-relaxed max-w-lg">
                    Si has llegado a mí no es por casualidad sino por <em class="text-pink-600 not-italic font-semibold">«causalidad»</em>. Creo firmemente en las conexiones energéticas y el tarot no es únicamente una herramienta de predicción, sino una conexión profunda con el alma y la energía, que nos permite analizar, transformar y tomar decisiones con una visión amplia de la situación que estás viviendo.
                </p>
                <p class="text-gray-700 leading-relaxed max-w-lg">
                    Además del tarot evolutivo también utilizo oráculos, lectura con bola de cristal y péndulo, y completamos con trabajos energéticos, rituales de alta magia con mucha fuerza que te llevarán a cumplir tus deseos.
                </p>
                <div class="pt-4 flex flex-wrap gap-3">
                    <a href="{{ route('booking') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-xl font-bold tracking-widest uppercase text-sm bg-pink-500 hover:bg-pink-600 text-white shadow-lg shadow-pink-500/25 transition-all hover:shadow-xl">
                        Reserva tu lectura
                    </a>
                    <a href="https://wa.me/34695619087" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 px-6 py-4 rounded-xl font-bold tracking-widest uppercase text-sm border-2 border-green-400 text-green-600 hover:bg-green-50 transition">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.82 11.82 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/></svg>
                        WhatsApp
                    </a>
                </div>
            </div>

            <div class="relative order-1 lg:order-2">
                <div class="absolute inset-0 bg-pink-300/20 blur-3xl rounded-full scale-90"></div>
                <div class="relative aspect-[4/5] max-w-md mx-auto rounded-2xl overflow-hidden border-2 border-pink-200 shadow-2xl shadow-pink-200/40">
                    <img src="/images/branding/foto-maria-jose-hechizosdemaria-sobre-mi.jpg"
                         alt="María José Gómez — Tarotista profesional"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-pink-900/40 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-center">
                        <span class="text-white text-xs tracking-[0.4em] uppercase font-heading font-semibold drop-shadow-lg">Hechizos de María</span>
                    </div>
                </div>

                {{-- Floating badge --}}
                <div class="hidden md:flex absolute -bottom-4 -left-4 bg-white rounded-2xl shadow-xl border border-pink-100 p-4 items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-pink-600 flex items-center justify-center text-white font-heading font-bold text-xl">15+</div>
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Años</p>
                        <p class="text-sm font-semibold text-gray-800">de experiencia</p>
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
            <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-2">Mi esencia</p>
            <h2 class="font-heading text-3xl md:text-4xl text-pink-700">Lo que soy</h2>
            <div class="w-24 h-px bg-pink-300 mx-auto mt-4"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
            @foreach([
                ['astroloca','Astróloga','M12 2v2m0 16v2m10-10h-2M4 12H2m16.364-7.364l-1.414 1.414M6.05 17.95l-1.414 1.414m14.142 0l-1.414-1.414M6.05 6.05L4.636 4.636M12 7a5 5 0 100 10 5 5 0 000-10z'],
                ['tarot','Maestra del Tarot','M4 4h6v16H4zM14 4h6v16h-6zM7 8v8M17 8v8'],
                ['vidente','Vidente','M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178zM15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                ['ritualista','Ritualista','M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z'],
                ['escritora','Escritora','M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zM19.5 7.125l-3-3'],
                ['meditacion','Guía de meditación','M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59'],
            ] as [$key, $label, $path])
                <div class="bg-white border border-pink-100 p-6 rounded-2xl text-center space-y-3 hover:shadow-lg hover:shadow-pink-100/50 hover:-translate-y-1 transition-all">
                    <div class="mx-auto w-12 h-12 rounded-full bg-pink-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/>
                        </svg>
                    </div>
                    <h3 class="font-heading text-base text-gray-800">{{ $label }}</h3>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- BOLA DE CRISTAL (sección destacada) --}}
<section class="py-20 bg-gradient-to-br from-pink-500 to-pink-700 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="stars-about" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                    <circle cx="40" cy="40" r="1" fill="white"/>
                    <circle cx="15" cy="20" r="0.5" fill="white"/>
                    <circle cx="65" cy="60" r="0.5" fill="white"/>
                    <circle cx="20" cy="65" r="0.7" fill="white"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#stars-about)"/>
        </svg>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-white space-y-6">
                <span class="inline-flex items-center gap-2 text-pink-200 text-xs tracking-[0.4em] uppercase">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                    Cristalomancia
                </span>
                <h2 class="font-heading text-3xl md:text-5xl italic leading-tight">Lectura con bola de cristal</h2>
                <p class="text-pink-100 leading-relaxed text-lg">
                    Una de las técnicas más antiguas de adivinación. La bola de cristal permite visualizar futuros cercanos y lejanos, y obtener respuestas claras de sí/no a tus preguntas más importantes.
                </p>
                <p class="text-pink-100 leading-relaxed">
                    Durante la lectura canalizo tu energía a través del cristal para captar imágenes, símbolos y sensaciones que revelan lo que el universo tiene preparado para ti.
                </p>
                <div class="pt-2">
                    <a href="{{ route('booking') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-xl font-bold tracking-widest uppercase text-sm bg-white text-pink-600 hover:bg-pink-50 transition shadow-lg">
                        Reservar lectura
                    </a>
                </div>
            </div>

            {{-- Animated crystal ball --}}
            <div class="relative flex items-center justify-center">
                <div class="relative w-72 h-72 md:w-80 md:h-80">
                    {{-- Outer glow --}}
                    <div class="absolute inset-0 rounded-full bg-white/10 blur-3xl animate-pulse" style="animation-duration:4s"></div>
                    {{-- Crystal ball --}}
                    <div class="absolute inset-4 rounded-full bg-gradient-to-br from-white/90 via-pink-100 to-pink-200 shadow-2xl overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-white/60 via-transparent to-pink-300/40"></div>
                        {{-- Highlight --}}
                        <div class="absolute top-8 left-10 w-20 h-16 bg-white/70 rounded-full blur-md"></div>
                        {{-- Mystical swirl --}}
                        <svg class="absolute inset-10 text-pink-400/40 animate-spin" style="animation-duration:30s" fill="none" stroke="currentColor" stroke-width="0.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" d="M12 2a10 10 0 019.5 7M12 22a10 10 0 01-9.5-7M22 12a10 10 0 01-7 9.5M2 12a10 10 0 017-9.5"/>
                            <circle cx="12" cy="12" r="5"/>
                            <path stroke-linecap="round" d="M12 7v10M7 12h10"/>
                        </svg>
                    </div>
                    {{-- Base --}}
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-40 h-8 bg-gradient-to-b from-pink-800 to-pink-900 rounded-[50%] shadow-xl"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MIS HERRAMIENTAS --}}
<section class="py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-2">Mis herramientas</p>
            <h2 class="font-heading text-3xl md:text-4xl text-pink-700 italic">Cómo trabajo</h2>
            <div class="w-24 h-px bg-pink-300 mx-auto mt-4"></div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white border border-pink-100 rounded-2xl p-6 text-center hover:shadow-lg hover:shadow-pink-100/50 transition-all">
                <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4h6v16H4zM14 4h6v16h-6z"/></svg>
                </div>
                <h3 class="font-heading text-lg text-gray-800 mb-2">Tarot evolutivo</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Lectura profunda del pasado, presente y futuro para tomar decisiones con claridad.</p>
            </div>

            <div class="bg-white border border-pink-100 rounded-2xl p-6 text-center hover:shadow-lg hover:shadow-pink-100/50 transition-all">
                <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="4"/></svg>
                </div>
                <h3 class="font-heading text-lg text-gray-800 mb-2">Oráculos</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Ángeles, runas y oráculos diversos como canales de mensajes concretos.</p>
            </div>

            <div class="bg-white border border-pink-100 rounded-2xl p-6 text-center hover:shadow-lg hover:shadow-pink-100/50 transition-all">
                <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v3m0 3l-2 7m2-7l2 7M9 22h6"/></svg>
                </div>
                <h3 class="font-heading text-lg text-gray-800 mb-2">Péndulo</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Respuestas rápidas sí/no para confirmar o descartar dudas concretas.</p>
            </div>

            <div class="bg-white border border-pink-100 rounded-2xl p-6 text-center hover:shadow-lg hover:shadow-pink-100/50 transition-all">
                <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003.001 2.48z"/></svg>
                </div>
                <h3 class="font-heading text-lg text-gray-800 mb-2">Rituales</h3>
                <p class="text-sm text-gray-600 leading-relaxed">Alta magia blanca personalizada para amor, prosperidad y protección.</p>
            </div>
        </div>
    </div>
</section>

{{-- FILOSOFÍA / CAUSALIDAD --}}
<section class="py-20 bg-pink-50/50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <svg class="w-12 h-12 text-pink-300 mx-auto mb-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z"/>
        </svg>
        <p class="font-heading text-2xl md:text-3xl italic text-pink-700 leading-relaxed mb-4">
            No existen las casualidades. Todo lo que llega a tu vida es energía en movimiento, y el tarot es el espejo que te ayuda a verla con claridad.
        </p>
        <p class="text-pink-400 text-xs tracking-[0.4em] uppercase">— María José Gómez</p>
    </div>
</section>

{{-- CTA FINAL --}}
<section class="py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-3">Tu momento es ahora</p>
        <h2 class="font-heading text-3xl md:text-5xl italic text-pink-700 mb-6 leading-tight">
            ¿Lista para conectar con tu energía?
        </h2>
        <p class="text-gray-600 mb-10 leading-relaxed">
            Elige entre una lectura personalizada, un ritual a medida o escríbeme directamente por WhatsApp. Estoy aquí para guiarte.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('booking') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-xl font-bold tracking-widest uppercase text-sm bg-pink-500 hover:bg-pink-600 text-white shadow-lg shadow-pink-500/25 transition-all">
                Reservar ahora
            </a>
            <a href="https://wa.me/34695619087?text={{ urlencode('Hola María José, me gustaría reservar una consulta') }}" target="_blank" rel="noopener"
               class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl font-bold tracking-widest uppercase text-sm border-2 border-green-400 text-green-600 hover:bg-green-50 transition">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.82 11.82 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/></svg>
                WhatsApp directo
            </a>
        </div>
    </div>
</section>

@endsection
