@extends('layouts.app')
@section('title', 'Iniciar sesión')
@section('content')
<section class="max-w-md mx-auto px-4 py-20">
    <h1 class="font-heading text-3xl text-pink-700 text-center mb-8">Iniciar sesión</h1>
    <form method="POST" action="{{ route('customer.login.post') }}" class="bg-white border border-pink-200 rounded-xl p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
            @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Contraseña *</label>
            <input type="password" name="password" required class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
        </div>
        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="remember" class="accent-pink-500"> Recordarme
        </label>
        <button type="submit" class="w-full bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 text-white font-bold uppercase tracking-widest text-sm py-3 rounded-md">Entrar</button>
    </form>
    <p class="text-center text-sm text-gray-600 mt-4">¿No tienes cuenta? <a href="{{ route('customer.register') }}" class="text-pink-600 hover:text-pink-800 font-semibold">Regístrate</a></p>
</section>
@endsection
