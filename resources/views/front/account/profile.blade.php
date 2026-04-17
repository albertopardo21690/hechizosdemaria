@extends('layouts.app')
@section('title', 'Mi perfil')
@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <p class="text-pink-500 text-xs tracking-[0.4em] uppercase mb-1">Mi cuenta</p>
    <h1 class="font-heading text-3xl text-pink-700 mb-8">Mi perfil</h1>

    <div class="grid md:grid-cols-[200px_1fr] gap-8">
        @include('front.account._nav')

        <form method="POST" action="{{ route('account.profile.update') }}" class="bg-white border border-pink-200 rounded-xl p-6 space-y-4">
            @csrf @method('PUT')
            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-md p-3 text-sm">{{ session('status') }}</div>
            @endif
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" required class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" value="{{ $customer->email }}" disabled class="w-full border border-gray-200 bg-gray-50 rounded-md px-3 py-2 text-gray-500">
                    <p class="text-xs text-gray-400 mt-1">El email no se puede cambiar.</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                    <input type="tel" name="phone" value="{{ old('phone', $customer->phone) }}" class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Ciudad</label>
                    <input type="text" name="city" value="{{ old('city', $customer->city) }}" class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Dirección</label>
                    <input type="text" name="address" value="{{ old('address', $customer->address) }}" class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Código postal</label>
                    <input type="text" name="postcode" value="{{ old('postcode', $customer->postcode) }}" class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                </div>
            </div>
            <button type="submit" class="bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 text-white font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-md">Guardar cambios</button>
        </form>
    </div>
</section>
@endsection
