@extends('layouts.app')

@section('title', 'Lecturas de tarot por María José — Hechizos de María')

@section('content')

{{-- 1. HERO --}}
<section class="relative overflow-hidden min-h-[85vh] flex items-center bg-gradient-to-br from-pink-50 via-white to-pink-100">
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute top-10 right-10 w-96 h-96 bg-pink-200/30 rounded-full blur-3xl animate-pulse" style="animation-duration:8s"></div>
        <div class="absolute bottom-10 left-10 w-80 h-80 bg-pink-100/50 rounded-full blur-3xl animate-pulse" style="animation-duration:6s"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 w-full">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-pink-400 text-xs tracking-[0.4em] uppercase block mb-5">Tarotista profesional</span>
                <h1 class="font-heading text-4xl md:text-6xl lg:text-7xl mb-6 leading-[1.05] text-pink-800">
                    Tu <span class="italic text-pink-500">lectura</span> te espera
                </h1>
                <p class="text-lg text-gray-600 mb-8 max-w-xl leading-relaxed">
                    Consultas de tarot, péndulo y bola de cristal. Más de 15 años guiando almas en España, Estados Unidos y México.
                </p>

                {{-- Trust indicators inline --}}
                <div class="flex flex-wrap items-center gap-5 mb-10 text-sm text-gray-500">
                    <span class="flex items-center gap-1.5">
                        <span class="text-pink-400 text-base">★★★★★</span>
                        <span class="font-semibold">5.0</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        15+ años
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5.8 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1.84-.1z"/></svg>
                        164k+ en TikTok
                    </span>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('booking') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-xl font-bold tracking-widest uppercase text-sm bg-pink-500 hover:bg-pink-600 text-white shadow-lg shadow-pink-500/25 transition-all hover:shadow-xl">
                        Reserva tu lectura
                    </a>
                    <a href="#gabinete-24h" class="inline-flex items-center gap-2 px-6 py-4 rounded-xl font-bold tracking-widest uppercase text-sm border-2 border-pink-300 text-pink-600 hover:bg-pink-50 transition">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-400"></span>
                        </span>
                        Gabinete 24h
                    </a>
                </div>
            </div>

            {{-- Hero photo (pending new photo from María José - tarot cards + white blouse) --}}
            <div class="hidden lg:block relative">
                <div class="absolute inset-0 bg-pink-300/20 blur-3xl rounded-full scale-90"></div>
                <div class="relative aspect-[4/5] max-w-md ml-auto rounded-2xl overflow-hidden border-2 border-pink-200 shadow-2xl shadow-pink-200/30">
                    {{-- TODO: cambiar por la nueva foto (blusa blanca + cartas de tarot) cuando esté disponible --}}
                    <img src="/images/branding/foto-maria-jose-hechizosdemaria.jpg"
                         alt="María José Gómez — Tarotista profesional"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-pink-900/30 via-transparent to-transparent"></div>
                </div>

                <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl shadow-xl border border-pink-100 p-4 flex items-center gap-3">
                    <div class="flex -space-x-2">
                        @foreach(['LM', 'CV', 'IR'] as $initial)
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 border-2 border-white flex items-center justify-center text-white text-xs font-bold">{{ $initial }}</div>
                        @endforeach
                    </div>
                    <div>
                        <div class="text-pink-400 text-xs">★★★★★</div>
                        <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold">+500 consultas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 2. LECTURAS (sección principal) --}}
@if($lecturas->count())
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-2">Consultas personalizadas</p>
            <h2 class="font-heading text-3xl md:text-5xl text-pink-700 italic">Lecturas disponibles</h2>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto leading-relaxed">Desde una pregunta rápida al péndulo hasta una lectura Premium en profundidad. Elige la que mejor se adapte a tu consulta.</p>
            <div class="w-24 h-px bg-pink-300 mx-auto mt-6"></div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($lecturas as $lectura)
                @php
                    $name = $lectura->attribute_data['name']?->getValue() ?? '-';
                    $slug = $lectura->urls->where('default', true)->first()?->slug ?? $lectura->urls->first()?->slug;
                    $variant = $lectura->variants->first();
                    $eurPrice = $variant?->prices->firstWhere('currency.code', 'EUR') ?? $variant?->prices->first();
                    $image = $lectura->getFirstMedia('images');
                @endphp
                <a href="{{ $slug ? route('product', $slug) : '#' }}"
                   class="group bg-white border border-pink-100 rounded-2xl overflow-hidden hover:border-pink-400 hover:shadow-xl hover:shadow-pink-100/50 hover:-translate-y-1 transition-all duration-500">
                    <div class="relative aspect-[4/5] bg-gradient-to-br from-pink-50 to-white overflow-hidden">
                        @if($image)
                            <img src="{{ $image->getUrl('medium') }}" alt="{{ $name }}" loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            {{-- Decorative fallback with tarot icon --}}
                            <div class="w-full h-full flex items-center justify-center">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-pink-300 rounded-lg rotate-6 opacity-30"></div>
                                    <div class="relative bg-white rounded-lg w-20 h-28 shadow-lg flex items-center justify-center border border-pink-200">
                                        <svg class="w-10 h-10 text-pink-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($eurPrice)
                            <span class="absolute top-3 right-3 bg-white text-pink-600 text-xs font-bold px-3 py-1 rounded-full shadow-md">
                                {{ number_format($eurPrice->price->decimal, 0) }}€
                            </span>
                        @endif
                    </div>

                    <div class="p-4">
                        <h3 class="font-heading text-base text-gray-800 group-hover:text-pink-600 transition-colors leading-snug min-h-[3rem]">{{ $name }}</h3>
                        <span class="inline-flex items-center gap-1 text-pink-500 text-[10px] uppercase tracking-widest font-bold mt-2 group-hover:gap-2 transition-all">
                            Reservar <span>→</span>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('collection', 'lecturas') }}" class="inline-flex items-center gap-2 text-pink-500 hover:text-pink-700 text-xs tracking-[0.3em] uppercase font-bold hover:gap-4 transition-all">
                Ver todas las lecturas <span>→</span>
            </a>
        </div>
    </div>
</section>
@endif

{{-- 3. GABINETE 24H --}}
<section id="gabinete-24h" class="py-20 bg-gradient-to-br from-pink-900 via-pink-800 to-pink-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="stars-24h" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                    <circle cx="10" cy="15" r="0.8" fill="white"/>
                    <circle cx="35" cy="40" r="0.5" fill="white"/>
                    <circle cx="50" cy="10" r="0.6" fill="white"/>
                    <circle cx="25" cy="50" r="0.4" fill="white"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#stars-24h)"/>
        </svg>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-white space-y-6">
                <span class="inline-flex items-center gap-2 text-pink-200 text-xs tracking-[0.4em] uppercase">
                    <span class="flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-400"></span>
                    </span>
                    Gabinete 24h
                </span>
                <h2 class="font-heading text-4xl md:text-5xl italic leading-tight">Tarot 24 horas por WhatsApp</h2>
                <p class="text-pink-100 leading-relaxed">
                    Tu consulta privada sin esperas. Disponibles las 24 horas del día, los 7 días de la semana.
                </p>

                {{-- Disclaimer destacado sobre el equipo --}}
                <div class="bg-white/10 backdrop-blur-sm border-l-4 border-pink-300 rounded-r-xl p-5">
                    <div class="flex gap-3">
                        <svg class="w-6 h-6 text-pink-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                        <p class="text-sm text-white leading-relaxed">
                            El gabinete de Hechizos de María cuenta con un <strong class="text-pink-200">equipo de tarotistas profesionales disponibles 24h</strong>. Al contactar, serás atendido/a por un miembro de nuestro equipo, <strong class="text-pink-200">no necesariamente por María en persona</strong>.
                        </p>
                    </div>
                </div>

                {{-- Tarifas --}}
                <div class="grid grid-cols-3 gap-2">
                    @foreach([['10', '13'], ['20', '26'], ['30', '39']] as [$min, $price])
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-3 text-center">
                            <p class="font-heading text-2xl text-white">{{ $price }}€</p>
                            <p class="text-[10px] uppercase tracking-widest text-pink-200 font-bold mt-0.5">{{ $min }} min</p>
                        </div>
                    @endforeach
                </div>

                {{-- Teléfonos internacionales --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                    <a href="tel:+34912142864" class="flex items-center gap-1.5 text-pink-200 hover:text-white transition">
                        <span class="text-base">🇪🇸</span> ESP: +34 912 142 864
                    </a>
                    <a href="tel:+19185409174" class="flex items-center gap-1.5 text-pink-200 hover:text-white transition">
                        <span class="text-base">🇺🇸</span> USA: +1 918 540 9174
                    </a>
                    <a href="tel:+525593178566" class="flex items-center gap-1.5 text-pink-200 hover:text-white transition">
                        <span class="text-base">🇲🇽</span> MX: +52 559 317 8566
                    </a>
                </div>

                <div>
                    <a href="https://wa.me/34695619087?text={{ urlencode('Hola, quiero una consulta de Tarot 24h') }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold text-sm uppercase tracking-widest px-8 py-4 rounded-xl transition shadow-lg">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.82 11.82 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/></svg>
                        Consultar por WhatsApp
                    </a>
                </div>
            </div>

            <div class="relative flex items-center justify-center">
                <div class="absolute inset-0 bg-pink-400/20 blur-3xl rounded-full scale-75"></div>
                <div class="relative max-w-md w-full rounded-2xl overflow-hidden shadow-2xl shadow-black/40 border border-pink-300/20">
                    <img src="/storage/media/branding/24horas-0za6bX.jpg"
                         alt="Gabinete Tarot 24h"
                         class="w-full h-auto object-cover"
                         onerror="this.onerror=null; this.src='/images/branding/foto-maria-jose-hechizosdemaria.jpg'">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 4. ACCESO TIENDA MÁGICA (banner compacto, SIN productos físicos visibles) --}}
<section class="py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-pink-100 via-white to-pink-50 border-2 border-pink-200 shadow-xl">
            <div class="grid lg:grid-cols-2 gap-0">
                <div class="p-10 lg:p-16 flex flex-col justify-center">
                    <span class="inline-block text-pink-500 text-xs tracking-[0.4em] uppercase mb-3 font-bold">Tienda Mágica</span>
                    <h2 class="font-heading text-3xl md:text-5xl text-pink-700 italic mb-4 leading-tight">Productos consagrados</h2>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Amuletos, cuarzos, perfumes, velas y rituales personalizados. Cada producto consagrado bajo la luz de la luna por María José.
                    </p>
                    <p class="text-sm text-pink-600 font-semibold mb-8">
                        Envío gratis a partir de 50€ · Desde 29€
                    </p>
                    <a href="{{ route('shop') }}" class="inline-flex items-center justify-center gap-2 self-start px-8 py-4 rounded-xl font-bold tracking-widest uppercase text-sm bg-pink-500 hover:bg-pink-600 text-white shadow-lg shadow-pink-500/25 transition">
                        Explorar tienda
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>

                <div class="relative bg-gradient-to-br from-pink-500 to-pink-700 min-h-[320px] flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 opacity-20">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="30" r="1.5" fill="white"/>
                            <circle cx="60" cy="20" r="1" fill="white"/>
                            <circle cx="80" cy="50" r="1.2" fill="white"/>
                            <circle cx="30" cy="70" r="0.8" fill="white"/>
                            <circle cx="70" cy="80" r="1.5" fill="white"/>
                        </svg>
                    </div>
                    <div class="relative text-center text-white">
                        <svg class="w-24 h-24 mx-auto mb-4 opacity-90" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                        </svg>
                        <p class="font-heading text-2xl italic">Hechizos de María</p>
                        <p class="text-pink-200 text-xs tracking-[0.3em] uppercase mt-1">Magia blanca</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 5. TESTIMONIOS --}}
@if($testimonials->count())
<section class="py-20 bg-pink-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-2">Experiencias reales</p>
            <h2 class="font-heading text-3xl md:text-4xl text-pink-700 italic">Lo que dicen los consultantes</h2>
            <div class="w-24 h-px bg-pink-300 mx-auto mt-4"></div>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $i => $t)
                <div class="bg-white border border-pink-100 rounded-2xl p-8 @if($i % 2 === 1) lg:mt-8 @endif hover:shadow-lg hover:shadow-pink-100/50 transition-all duration-300">
                    <div class="text-pink-400 mb-3 text-lg tracking-wide">
                        {!! str_repeat('★', $t->rating) !!}{!! str_repeat('<span class="text-pink-200">★</span>', 5 - $t->rating) !!}
                    </div>
                    <p class="text-gray-600 mb-6 italic leading-relaxed">"{{ $t->text }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-white font-heading font-bold text-sm">
                            {{ mb_substr($t->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 text-sm">{{ $t->name }}</div>
                            @if($t->location)<div class="text-gray-400 text-xs">{{ $t->location }}</div>@endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('testimonials') }}" class="inline-flex items-center gap-2 text-pink-500 hover:text-pink-700 text-xs tracking-[0.3em] uppercase font-bold hover:gap-4 transition-all">
                Ver todos los testimonios <span>→</span>
            </a>
        </div>
    </div>
</section>
@endif

{{-- 6. NEWSLETTER --}}
<section class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative p-10 md:p-16 rounded-3xl overflow-hidden bg-gradient-to-br from-pink-500 via-pink-600 to-pink-700 text-center shadow-xl shadow-pink-500/20">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="stars-pattern" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                            <circle cx="30" cy="30" r="1" fill="white"/>
                            <circle cx="10" cy="10" r="0.5" fill="white"/>
                            <circle cx="50" cy="15" r="0.5" fill="white"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#stars-pattern)"/>
                </svg>
            </div>
            <div class="relative z-10 max-w-2xl mx-auto">
                <p class="text-pink-200 text-xs tracking-[0.4em] uppercase mb-3">Boletín</p>
                <h2 class="font-heading text-3xl md:text-4xl mb-4 italic text-white">Únete al aquelarre</h2>
                <p class="text-pink-100 mb-8 leading-relaxed">Recibe horóscopo semanal, mensajes del tarot y acceso prioritario a mis lecturas especiales.</p>
                <div class="max-w-md mx-auto">
                    <livewire:newsletter-signup />
                </div>
                <p class="text-[10px] uppercase tracking-widest mt-5 text-pink-200/60">Al suscribirte aceptas nuestra política de privacidad</p>
            </div>
        </div>
    </div>
</section>

{{-- 7. SÍGUEME EN REDES --}}
<section class="py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-2">Sígueme</p>
            <h2 class="font-heading text-3xl md:text-4xl text-pink-700 italic">La comunidad mágica</h2>
            <div class="w-24 h-px bg-pink-300 mx-auto mt-4"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-5">
            <a href="https://www.tiktok.com/@hechizosdemariatarot" target="_blank" rel="noopener"
               class="group bg-gradient-to-br from-gray-900 to-black text-white rounded-2xl p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-500 relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-pink-500/20 rounded-full blur-3xl group-hover:bg-pink-500/30 transition"></div>
                <div class="relative">
                    <div class="w-14 h-14 rounded-full bg-white/10 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5.8 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1.84-.1z"/></svg>
                    </div>
                    <p class="font-heading text-3xl mb-1">164k+</p>
                    <p class="text-white/70 text-sm mb-4">seguidores en TikTok</p>
                    <p class="text-[10px] uppercase tracking-widest font-bold flex items-center gap-1">
                        @hechizosdemariatarot
                        <svg class="w-3 h-3 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </p>
                </div>
            </a>

            <a href="https://www.instagram.com/hechizosdemaria_tarot/" target="_blank" rel="noopener"
               class="group bg-gradient-to-br from-pink-500 via-purple-500 to-orange-400 text-white rounded-2xl p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-500 relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
                <div class="relative">
                    <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </div>
                    <p class="font-heading text-3xl mb-1">Instagram</p>
                    <p class="text-white/80 text-sm mb-4">Stories diarias y rituales</p>
                    <p class="text-[10px] uppercase tracking-widest font-bold flex items-center gap-1">
                        @hechizosdemaria_tarot
                        <svg class="w-3 h-3 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </p>
                </div>
            </a>

            <a href="https://www.youtube.com/@hechizosdemaria_tarot" target="_blank" rel="noopener"
               class="group bg-gradient-to-br from-red-600 to-red-700 text-white rounded-2xl p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-500 relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
                <div class="relative">
                    <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </div>
                    <p class="font-heading text-3xl mb-1">YouTube</p>
                    <p class="text-white/80 text-sm mb-4">Lecturas grupales</p>
                    <p class="text-[10px] uppercase tracking-widest font-bold flex items-center gap-1">
                        @hechizosdemaria_tarot
                        <svg class="w-3 h-3 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </p>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- 8. BLOG --}}
@if($posts->count())
<section class="py-20 bg-pink-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-2">Saberes</p>
            <h2 class="font-heading text-3xl md:text-4xl text-pink-700 italic">Grimorio digital</h2>
            <div class="w-24 h-px bg-pink-300 mx-auto mt-4"></div>
        </div>
        <div class="grid md:grid-cols-3 gap-10">
            @foreach($posts as $post)
                <article class="group">
                    <span class="text-pink-400 text-xs font-bold uppercase tracking-widest block mb-3">
                        {{ optional($post->published_at)->format('d M, Y') ?? $post->created_at->format('d M, Y') }}
                    </span>
                    <h3 class="font-heading text-2xl text-gray-800 mb-4 group-hover:text-pink-600 transition-colors">{{ $post->title }}</h3>
                    <p class="text-gray-500 mb-6 line-clamp-3 leading-relaxed">{{ $post->excerpt ?? strip_tags($post->content) }}</p>
                    <a href="#" class="inline-flex items-center gap-2 font-bold uppercase text-[10px] tracking-[0.3em] text-pink-500 group-hover:gap-4 transition-all">
                        Leer más <span>→</span>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
