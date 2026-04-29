@extends('layouts.app')
@section('title', 'Testimonios de clientes')
@section('meta_description', 'Lo que dicen las personas que han confiado en María José: lecturas de tarot, rituales, bola de cristal y productos mágicos. Más de '.$stats['total'].' experiencias reales.')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden bg-gradient-to-br from-pink-50 via-white to-pink-100 py-16 lg:py-24">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-3">Experiencias reales</p>
        <h1 class="font-heading text-4xl md:text-6xl text-pink-800 italic mb-6 leading-tight">
            Lo que dicen los <span class="text-pink-500">consultantes</span>
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto mb-10 leading-relaxed">
            Decenas de personas han confiado en María José para sus consultas, rituales y productos mágicos. Estos son algunos de sus testimonios.
        </p>

        {{-- Stats --}}
        <div class="inline-flex items-center gap-8 bg-white rounded-2xl border border-pink-100 shadow-sm px-8 py-4">
            <div class="text-center">
                <p class="font-heading text-3xl text-pink-600">{{ $stats['total'] }}</p>
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Testimonios</p>
            </div>
            <div class="h-12 w-px bg-pink-100"></div>
            <div class="text-center">
                <div class="flex items-center gap-1 justify-center text-pink-400 text-lg">
                    @for($i = 0; $i < 5; $i++)★@endfor
                </div>
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">{{ $stats['avg'] }} media</p>
            </div>
            <div class="h-12 w-px bg-pink-100"></div>
            <div class="text-center">
                <p class="font-heading text-3xl text-pink-600">15+</p>
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Años de experiencia</p>
            </div>
        </div>
    </div>
</section>

{{-- Filter chips --}}
<section class="py-10 border-b border-pink-100" x-data="{ filter: 'all' }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $typeLabels = [
                'lectura' => 'Lecturas',
                'ritual' => 'Rituales',
                'bola_cristal' => 'Bola de cristal',
                'tarot_24h' => 'Tarot 24h',
                'producto' => 'Productos',
            ];
        @endphp
        <div class="flex flex-wrap justify-center gap-2">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-pink-500 text-white' : 'bg-pink-50 text-pink-600 hover:bg-pink-100'" class="px-5 py-2.5 rounded-full text-xs uppercase tracking-widest font-bold transition">
                Todos ({{ $stats['total'] }})
            </button>
            @foreach($typeLabels as $key => $label)
                @if(isset($stats['by_type'][$key]))
                    <button @click="filter = '{{ $key }}'" :class="filter === '{{ $key }}' ? 'bg-pink-500 text-white' : 'bg-pink-50 text-pink-600 hover:bg-pink-100'" class="px-5 py-2.5 rounded-full text-xs uppercase tracking-widest font-bold transition">
                        {{ $label }} ({{ $stats['by_type'][$key] }})
                    </button>
                @endif
            @endforeach
        </div>

        {{-- Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
            @foreach($testimonials as $i => $t)
                <div x-show="filter === 'all' || filter === '{{ $t->service_type }}'"
                     x-transition
                     class="bg-white border border-pink-100 rounded-2xl p-6 hover:shadow-lg hover:shadow-pink-100/50 transition-all @if($i % 2 === 1) lg:mt-8 @endif">
                    {{-- Stars --}}
                    <div class="text-pink-400 mb-3 text-lg tracking-wide">
                        {!! str_repeat('★', $t->rating) !!}{!! str_repeat('<span class="text-pink-200">★</span>', 5 - $t->rating) !!}
                    </div>
                    {{-- Text --}}
                    <p class="text-gray-600 leading-relaxed italic mb-5">"{{ $t->text }}"</p>
                    {{-- Author + tag --}}
                    <div class="flex items-center justify-between gap-3 pt-4 border-t border-pink-50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-white font-heading font-bold text-sm flex-shrink-0">
                                {{ mb_substr($t->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800 text-sm">{{ $t->name }}</div>
                                @if($t->location)
                                    <div class="text-gray-400 text-xs">{{ $t->location }}</div>
                                @endif
                            </div>
                        </div>
                        @if($t->service_type && isset($typeLabels[$t->service_type]))
                            <span class="text-[10px] bg-pink-50 text-pink-500 font-bold uppercase tracking-widest px-2.5 py-1 rounded-full">{{ $typeLabels[$t->service_type] }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-heading text-3xl md:text-4xl text-pink-700 italic mb-4">¿Lista para tu experiencia?</h2>
        <p class="text-gray-600 mb-8 leading-relaxed">Únete a las cientos de personas que han encontrado claridad y transformación con María José.</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('booking') }}" class="inline-flex items-center justify-center px-8 py-4 rounded-xl font-bold tracking-widest uppercase text-sm bg-pink-500 hover:bg-pink-600 text-white shadow-lg shadow-pink-500/25 transition">
                Reservar consulta
            </a>
            <a href="https://wa.me/34695619087" target="_blank" rel="noopener" class="inline-flex items-center gap-2 justify-center px-8 py-4 rounded-xl font-bold tracking-widest uppercase text-sm border-2 border-green-400 text-green-600 hover:bg-green-50 transition">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.82 11.82 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/></svg>
                WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection
