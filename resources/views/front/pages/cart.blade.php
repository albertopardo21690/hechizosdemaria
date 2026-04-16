@extends('layouts.app')
@section('title', 'Carrito')
@section('content')
<section class="max-w-4xl mx-auto px-4 py-20 text-center">
    <h1 class="font-heading text-4xl text-shimmer mb-6">Tu carrito</h1>
    <p class="text-gray-400 mb-8">El carrito se implementara con Livewire en la siguiente sub-fase.</p>
    <a href="{{ route('shop') }}" class="btn-mystic">Seguir comprando</a>
</section>
@endsection
