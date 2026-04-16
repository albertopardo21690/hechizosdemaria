@extends('layouts.app')

@section('title', 'Hechizos de Maria - Tarot, rituales y magia blanca')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden min-h-[80vh] flex items-center">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-r from-mystic-900 via-mystic-900/90 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-mystic-900/40 to-mystic-950 z-10"></div>
    </div>

    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 w-full">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-gold-400 text-xs tracking-[0.4em] uppercase block mb-5">Sabiduria ancestral</span>
                <h1 class="font-heading text-4xl md:text-6xl lg:text-7xl mb-6 leading-[1.05]">
                    Descubre el poder de la <span class="text-shimmer italic">magia antigua</span>
                </h1>
                <p class="text-lg text-gray-300 mb-10 max-w-xl leading-relaxed">
                    Lecturas de tarot, rituales personalizados de alta magia y una tienda magica con perfumes arabes, amuletos y cuarzos consagrados bajo la luz de la luna.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('collection', 'lecturas') }}" class="btn-mystic">Reserva tu lectura</a>
                    <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-md font-semibold tracking-widest uppercase text-sm border border-white/20 text-white hover:bg-white/10 transition">
                        Ver rituales
                    </a>
                </div>
            </div>

            <div class="hidden lg:flex flex-col gap-6 relative">
                <div class="bg-mystic-800/80 backdrop-blur-md p-6 rounded-xl border border-gold-400/20 w-64 self-start">
                    <span class="font-heading text-3xl text-gold-400 block mb-1">164.7k</span>
                    <span class="text-xs text-gray-400 uppercase tracking-widest">Seguidores en TikTok</span>
                </div>
                <div class="bg-mystic-800/80 backdrop-blur-md p-6 rounded-xl border border-gold-400/20 w-64 self-end -mt-2">
                    <span class="font-heading text-3xl text-gold-400 block mb-1">2.2M</span>
                    <span class="text-xs text-gray-400 uppercase tracking-widest">Likes en TikTok</span>
                </div>
                <div class="bg-mystic-800/80 backdrop-blur-md p-6 rounded-xl border border-gold-400/20 w-64 self-start -mt-2">
                    <span class="font-heading text-3xl text-gold-400 block mb-1">Tarot 24h</span>
                    <span class="text-xs text-gray-400 uppercase tracking-widest">Por WhatsApp</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CATEGORIAS CIRCULARES --}}
@if($featuredCategories->count())
<section class="py-20 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Explora</p>
            <h2 class="font-heading text-3xl md:text-4xl mb-4">Nuestras artes</h2>
            <div class="w-24 h-px bg-gold-400 mx-auto"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($featuredCategories as $cat)
                <a href="{{ route('collection', $cat->slug) }}" class="group text-center">
                    <div class="aspect-square rounded-full overflow-hidden mb-4 border-2 border-transparent group-hover:border-gold-400 transition-all duration-500 p-1">
                        @if($cat->image)
                            <img src="{{ $cat->image }}" alt="{{ $cat->name }}" loading="lazy"
                                 class="w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full rounded-full bg-gradient-to-br from-purple-800/40 to-mystic-800/60 flex items-center justify-center text-gold-400/60">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <span class="font-heading text-base group-hover:text-gold-400 transition-colors">{{ $cat->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- LECTURAS --}}
@if($lecturas->count())
<section class="py-20 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Consultas personalizadas</p>
            <h2 class="font-heading text-3xl md:text-4xl">Lecturas de tarot</h2>
            <div class="w-24 h-px bg-gold-400 mx-auto mt-4"></div>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($lecturas as $product)
                @include('front.partials.product-card', ['product' => $product, 'badge' => null])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- RITUALES BANNER --}}
<section class="py-20 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center bg-gradient-to-br from-purple-900/40 to-mystic-800/60 border border-gold-500/20 rounded-3xl p-10 lg:p-16">
            <div>
                <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Alta magia</p>
                <h2 class="font-heading text-3xl md:text-4xl mb-4 italic">Rituales personalizados</h2>
                <p class="text-gray-300 mb-6 leading-relaxed">Cada ritual se adapta a tu situacion particular. Amor, proteccion, prosperidad, limpieza energetica. Magia blanca con intencion real, consagrada y canalizada por Maria Jose.</p>
                <a href="{{ route('collection', 'rituales') }}" class="btn-mystic">Descubre los rituales</a>
            </div>
            <div class="hidden lg:block text-center">
                <svg class="w-64 h-64 mx-auto text-gold-400/70 animate-pulse" style="animation-duration:4s" fill="none" stroke="currentColor" stroke-width="0.6" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20M2 12h20M4.9 4.9l14.2 14.2M19.1 4.9L4.9 19.1"/>
                </svg>
            </div>
        </div>
    </div>
</section>

{{-- TIENDA DESTACADOS --}}
@if($destacados->count())
<section class="py-20 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12 flex-wrap gap-4">
            <div>
                <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Tienda magica</p>
                <h2 class="font-heading text-3xl md:text-4xl">Productos destacados</h2>
            </div>
            <a href="{{ route('shop') }}" class="text-gold-400 hover:text-gold-300 text-xs tracking-[0.3em] uppercase font-bold inline-flex items-center gap-2 hover:gap-4 transition-all">
                Ver toda la tienda <span>&rarr;</span>
            </a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($destacados as $i => $product)
                @include('front.partials.product-card', [
                    'product' => $product,
                    'badge' => $i === 0 ? 'Nuevo' : ($i === 3 ? 'Bestseller' : null)
                ])
            @endforeach
        </div>
        <div class="text-center mt-8 text-sm text-gold-400/80 uppercase tracking-widest">Envio gratis a partir de 50€</div>
    </div>
</section>
@endif

{{-- TESTIMONIOS --}}
@if($testimonials->count())
<section class="py-20 bg-mystic-950/60 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Experiencias reales</p>
            <h2 class="font-heading text-3xl md:text-4xl italic">Lo que dicen los consultantes</h2>
            <div class="w-24 h-px bg-gold-400 mx-auto mt-4"></div>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $i => $t)
                <div class="bg-mystic-800/50 backdrop-blur-sm border border-gold-500/10 rounded-2xl p-8 @if($i % 2 === 1) lg:mt-12 @endif hover:border-gold-400/40 transition-all">
                    <div class="text-gold-400 mb-3 text-lg">
                        {!! str_repeat('&#9733;', $t->rating) !!}
                    </div>
                    <p class="text-gray-300 mb-6 italic leading-relaxed">"{{ $t->text }}"</p>
                    <div class="text-sm">
                        <div class="font-semibold text-gold-400">{{ $t->name }}</div>
                        @if($t->location)<div class="text-gray-500 text-xs uppercase tracking-widest mt-1">{{ $t->location }}</div>@endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- NEWSLETTER --}}
<section class="py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative p-12 md:p-16 rounded-3xl overflow-hidden bg-gradient-to-br from-purple-900 via-purple-800 to-mystic-900 text-center">
            <div class="absolute inset-0 opacity-10 pointer-events-none text-gold-400">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="diamonds" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M20 0L40 20L20 40L0 20Z" fill="currentColor" opacity="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#diamonds)"/>
                </svg>
            </div>
            <div class="relative z-10 max-w-2xl mx-auto">
                <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-3">Boletin</p>
                <h2 class="font-heading text-3xl md:text-5xl mb-4 italic">Unete al aquelarre</h2>
                <p class="text-gray-300 mb-8 leading-relaxed">Recibe rituales semanales, significados de las lunas, horoscopo y acceso prioritario a ediciones limitadas.</p>
                <form class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto">
                    <input type="email" required placeholder="Tu correo electronico"
                           class="flex-1 px-5 py-4 bg-white/10 border border-white/20 rounded-md text-white placeholder:text-white/50 focus:border-gold-400 focus:outline-none backdrop-blur-sm">
                    <button type="submit" class="btn-mystic whitespace-nowrap">Suscribirse</button>
                </form>
                <p class="text-[10px] uppercase tracking-widest mt-5 text-white/40">Al suscribirte aceptas nuestra politica de privacidad</p>
            </div>
        </div>
    </div>
</section>

{{-- BLOG (opcional) --}}
@if($posts->count())
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Saberes</p>
            <h2 class="font-heading text-3xl md:text-4xl italic">Grimorio digital</h2>
            <div class="w-24 h-px bg-gold-400 mx-auto mt-4"></div>
        </div>
        <div class="grid md:grid-cols-3 gap-10">
            @foreach($posts as $post)
                <article class="group">
                    <span class="text-gold-400 text-xs font-bold uppercase tracking-widest block mb-3">
                        {{ optional($post->published_at)->format('d M, Y') ?? $post->created_at->format('d M, Y') }}
                    </span>
                    <h3 class="font-heading text-2xl mb-4 group-hover:text-gold-400 transition-colors">{{ $post->title }}</h3>
                    <p class="text-gray-400 mb-6 line-clamp-3 leading-relaxed">{{ $post->excerpt ?? strip_tags($post->content) }}</p>
                    <a href="#" class="inline-flex items-center gap-2 font-bold uppercase text-[10px] tracking-[0.3em] text-gold-400 group-hover:gap-4 transition-all">
                        Leer mas <span>&rarr;</span>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
