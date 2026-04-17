@extends('layouts.app')
@section('title', 'Reservar cita')
@section('content')
<section class="max-w-4xl mx-auto px-4 py-16">
    <div class="text-center mb-10">
        <p class="text-pink-500 text-xs tracking-[0.4em] uppercase mb-2">Reservas</p>
        <h1 class="font-heading text-4xl md:text-5xl text-pink-700 mb-3">Reserva tu sesión</h1>
        <p class="text-gray-600 max-w-lg mx-auto">Elige el servicio que necesitas, completa tus datos y María José se pondrá en contacto contigo.</p>
    </div>
    <livewire:booking-form />
</section>
@endsection
