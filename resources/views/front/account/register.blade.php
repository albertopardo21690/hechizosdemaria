@extends('layouts.app')
@section('title', 'Crear cuenta')
@section('content')
<section class="max-w-md mx-auto px-4 py-20">
    <h1 class="font-heading text-3xl text-pink-700 text-center mb-8">Crear cuenta</h1>
    <form method="POST" action="{{ route('customer.register.post') }}" class="bg-white border border-pink-200 rounded-xl p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre completo *</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
            @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
            @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Contraseña * (mín. 6 caracteres)</label>
            <input type="password" name="password" required class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
            @error('password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Confirmar contraseña *</label>
            <input type="password" name="password_confirmation" required class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
        </div>
        <button type="submit" class="w-full bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 text-white font-bold uppercase tracking-widest text-sm py-3 rounded-md">Crear cuenta</button>
    </form>
    <p class="text-center text-sm text-gray-600 mt-4">¿Ya tienes cuenta? <a href="{{ route('customer.login') }}" class="text-pink-600 hover:text-pink-800 font-semibold">Inicia sesión</a></p>
</section>
@endsection
