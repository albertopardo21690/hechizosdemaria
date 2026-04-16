@extends('layouts.app')
@section('title', '404 · Página no encontrada')

@section('content')
@php $tpl = \App\Models\ThemeTemplate::activeFor('error_404'); @endphp
@if($tpl && $tpl->hasBlocks())
    @foreach($tpl->sectionsNormalized() as $section)
        @include('front.sections.wrapper', ['section' => $section])
    @endforeach
@else
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <p class="text-pink-500 text-xs tracking-[0.4em] uppercase mb-4">Error 404</p>
        <h1 class="font-heading text-5xl md:text-6xl text-pink-700 mb-4">Página no encontrada</h1>
        <p class="text-gray-600 max-w-lg mx-auto mb-8">La página que buscas no existe o ha cambiado de dirección.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center bg-pink-500 hover:bg-pink-600 text-white font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-md">Volver al inicio</a>
    </section>
@endif
@endsection
