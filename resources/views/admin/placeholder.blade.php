@extends('admin.layouts.app')
@section('title', $title)
@section('page_title', $title)

@section('content')
<div class="bg-white border border-pink-200 rounded-xl p-12 text-center max-w-2xl mx-auto">
    <svg class="w-16 h-16 mx-auto text-pink-300 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <h2 class="font-heading text-2xl text-pink-700 mb-3">{{ $title }}</h2>
    <p class="text-gray-600 mb-6">Esta seccion se activa en la fase <strong>{{ $phase }}</strong> del nuevo admin.</p>
    <p class="text-sm text-gray-500">Mientras tanto puedes usar el admin antiguo (Filament) como fallback.</p>
    <a href="/filament" target="_blank" class="inline-block mt-6 bg-gradient-to-br from-pink-600 to-pink-500 text-white font-semibold uppercase tracking-widest text-xs px-6 py-3 rounded-md hover:from-pink-500 hover:to-pink-400 transition">
        Ir a admin antiguo
    </a>
</div>
@endsection
