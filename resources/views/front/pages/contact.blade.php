@extends('layouts.app')
@section('title', 'Contacto')
@section('content')
<section class="max-w-2xl mx-auto px-4 py-20">
    <div class="text-center mb-12">
        <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Hablemos</p>
        <h1 class="font-heading text-4xl md:text-5xl text-shimmer">Contacto</h1>
    </div>

    <div class="bg-mystic-800/50 border border-gold-500/10 rounded-xl p-8 space-y-6">
        <p class="text-gray-300">
            Para consultas rapidas o reservar una lectura, el canal mas agil es WhatsApp:
        </p>
        <a href="https://wa.me/34695619087" target="_blank" rel="noopener" class="btn-mystic w-full">
            Escribir por WhatsApp
        </a>
        <div class="text-center text-gray-500">o por email</div>
        <a href="mailto:hechizosdemaria@gmail.com" class="block text-center text-gold-400 hover:text-gold-300 text-lg">
            hechizosdemaria@gmail.com
        </a>
    </div>
</section>
@endsection
