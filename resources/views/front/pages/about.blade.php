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
                <span class="text-gold-400 text-xs tracking-[0.3em] uppercase block">Conoceme</span>
                <h1 class="font-heading text-5xl md:text-6xl lg:text-7xl italic text-shimmer leading-[1.05]">Soy Maria Jose</h1>
                <p class="font-heading text-xl md:text-2xl italic text-gold-300/90 max-w-md">Tarotista profesional, astrologa, ritualista y escritora</p>
                <p class="text-gray-300 leading-relaxed max-w-lg">
                    Si has llegado a mi no es por casualidad sino por <em class="text-gold-400 not-italic">&laquo;causalidad&raquo;</em>. Creo firmemente en las conexiones energeticas y el tarot no es unicamente una herramienta de prediccion, sino una conexion profunda con el alma y la energia, que nos permite analizar, transformar y tomar decisiones con vision amplia.
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
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-8-4.5-8-11a5 5 0 019-3 5 5 0 019 3c0 6.5-8 11-8 11h-2z"/>
                    <path stroke-linecap="round" d="M12 4v7"/>
                </svg>
                <h3 class="font-heading text-lg">Ritualista</h3>
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

{{-- METODOS --}}
<section class="py-20 bg-mystic-950/60">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Mis metodos</p>
            <h2 class="font-heading text-3xl md:text-4xl italic">Herramientas del alma</h2>
            <div class="w-24 h-px bg-gold-400 mx-auto mt-4"></div>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-mystic-800/50 backdrop-blur-sm p-8 rounded-2xl border border-gold-500/15 flex items-start gap-5 hover:border-gold-400/40 transition">
                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gold-400/10 border border-gold-400/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path stroke-linecap="round" d="M9 5v14M15 5v14"/></svg>
                </div>
                <div>
                    <h4 class="font-heading text-xl mb-1">Tarot evolutivo</h4>
                    <p class="text-gray-400 leading-relaxed">No solo predecimos: conectamos con tu alma y tu proposito de vida para transformar lo que estas viviendo.</p>
                </div>
            </div>

            <div class="bg-mystic-800/50 backdrop-blur-sm p-8 rounded-2xl border border-gold-500/15 flex items-start gap-5 hover:border-gold-400/40 transition">
                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gold-400/10 border border-gold-400/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </div>
                <div>
                    <h4 class="font-heading text-xl mb-1">Oraculos</h4>
                    <p class="text-gray-400 leading-relaxed">Mensajes directos del universo para tu dia a dia, canalizados con cartas angelicales, gitanas y oraculos especializados.</p>
                </div>
            </div>

            <div class="bg-mystic-800/50 backdrop-blur-sm p-8 rounded-2xl border border-gold-500/15 flex items-start gap-5 hover:border-gold-400/40 transition">
                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gold-400/10 border border-gold-400/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><circle cx="9" cy="9" r="2" fill="currentColor" opacity="0.4"/></svg>
                </div>
                <div>
                    <h4 class="font-heading text-xl mb-1">Bola de cristal</h4>
                    <p class="text-gray-400 leading-relaxed">Cristalomancia, una de las tecnicas ancestrales mas antiguas: visualizacion de futuro cercano y lejano con respuestas claras.</p>
                </div>
            </div>

            <div class="bg-mystic-800/50 backdrop-blur-sm p-8 rounded-2xl border border-gold-500/15 flex items-start gap-5 hover:border-gold-400/40 transition">
                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gold-400/10 border border-gold-400/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 3v7M12 21l-2-4M12 21l2-4"/><circle cx="12" cy="12" r="2"/></svg>
                </div>
                <div>
                    <h4 class="font-heading text-xl mb-1">Pendulo</h4>
                    <p class="text-gray-400 leading-relaxed">Radiestesia precisa para respuestas Si/No y para armonizar tu energia. Combinable con tarot o bola de cristal.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PHILOSOPHY --}}
<section class="relative py-24 md:py-32 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-purple-900 via-purple-800/80 to-mystic-900"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(96,51,137,0.5)_0%,transparent_70%)]"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
        <svg class="w-10 h-10 mx-auto text-gold-400/60 mb-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M9 8v6H5v-6h4m1-4H4a1 1 0 00-1 1v10a1 1 0 001 1h5v4l4-4h1a1 1 0 001-1V5a1 1 0 00-1-1h-5zm11 0h-6a1 1 0 00-1 1v14l4-4h3a1 1 0 001-1V5a1 1 0 00-1-1z"/>
        </svg>
        <blockquote class="font-heading text-2xl md:text-4xl italic text-gold-300 leading-tight">
            El tarot no es unicamente una herramienta de prediccion, sino una conexion profunda con el alma y la energia
        </blockquote>
        <p class="mt-6 text-gold-400/80 text-sm tracking-[0.3em] uppercase">Maria Jose</p>
    </div>
</section>

{{-- RITUALES --}}
<section class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Magia blanca</p>
        <h2 class="font-heading text-3xl md:text-4xl">Rituales de alta magia</h2>
        <div class="w-24 h-px bg-gold-400 mx-auto mt-4 mb-8"></div>

        <div class="relative inline-block mb-6">
            <div class="absolute inset-0 bg-gold-400/20 blur-2xl rounded-full"></div>
            <svg class="relative w-28 h-28 mx-auto text-gold-400" fill="none" stroke="currentColor" stroke-width="0.8" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l2.39 7.36H22l-6.18 4.49 2.36 7.36L12 16.72 5.82 21.21l2.36-7.36L2 9.36h7.61z"/>
            </svg>
        </div>

        <p class="text-gray-300 leading-relaxed text-lg max-w-2xl mx-auto mb-8">
            Trabajos energeticos personalizados, consagrados y canalizados a tu situacion particular. Amor, proteccion, prosperidad, limpieza energetica. Magia blanca con intencion real para abrir caminos y cumplir tus deseos.
        </p>

        <a href="{{ route('collection', 'rituales') }}" class="inline-flex items-center gap-2 text-gold-400 font-bold uppercase text-xs tracking-[0.3em] border-b border-gold-400/60 pb-1 hover:gap-4 transition-all">
            Ver rituales <span>&rarr;</span>
        </a>
    </div>
</section>

{{-- STATS --}}
<section class="py-16 bg-mystic-950/80">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="border border-gold-400/20 p-6 rounded-xl text-center bg-mystic-800/40">
                <span class="block font-heading text-3xl text-gold-400 mb-1">15+</span>
                <span class="text-[10px] text-gray-400 uppercase tracking-widest">Anos de experiencia</span>
            </div>
            <div class="border border-gold-400/20 p-6 rounded-xl text-center bg-mystic-800/40">
                <span class="block font-heading text-3xl text-gold-400 mb-1">164.7k</span>
                <span class="text-[10px] text-gray-400 uppercase tracking-widest">Seguidores TikTok</span>
            </div>
            <div class="border border-gold-400/20 p-6 rounded-xl text-center bg-mystic-800/40">
                <span class="block font-heading text-3xl text-gold-400 mb-1">2.2M</span>
                <span class="text-[10px] text-gray-400 uppercase tracking-widest">Likes acumulados</span>
            </div>
            <div class="border border-gold-400/20 p-6 rounded-xl text-center bg-mystic-800/40">
                <span class="block font-heading text-3xl text-gold-400 mb-1">&#9733; 4.9</span>
                <span class="text-[10px] text-gray-400 uppercase tracking-widest">Valoracion media</span>
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
