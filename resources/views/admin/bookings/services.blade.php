@extends('admin.layouts.app')
@section('title', 'Servicios reservables')
@section('page_title', 'Servicios reservables ('.$services->count().')')

@section('content')
<div class="mb-6 text-right">
    <a href="{{ route('admin.bookings.services.create') }}" class="bg-gradient-to-br from-pink-600 to-pink-500 text-white font-semibold text-sm uppercase tracking-widest px-5 py-2.5 rounded-md">+ Nuevo servicio</a>
</div>

<div class="bg-white border border-pink-200 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-pink-50 text-left text-xs uppercase tracking-widest text-gray-600">
            <tr><th class="px-4 py-3">Nombre</th><th class="px-4 py-3">Categoría</th><th class="px-4 py-3">Precio</th><th class="px-4 py-3">Método</th><th class="px-4 py-3">Estado</th><th class="px-4 py-3"></th></tr>
        </thead>
        <tbody>
            @forelse($services as $s)
                <tr class="border-t border-pink-100 hover:bg-pink-50/30">
                    <td class="px-4 py-3 font-semibold">{{ $s->name }}</td>
                    <td class="px-4 py-3 text-xs">{{ \App\Models\BookingService::categories()[$s->category] ?? $s->category }}</td>
                    <td class="px-4 py-3">{{ number_format($s->price, 2, ',', '.') }} €</td>
                    <td class="px-4 py-3 text-xs">{{ \App\Models\BookingService::deliveryMethods()[$s->delivery_method] ?? $s->delivery_method }}</td>
                    <td class="px-4 py-3"><span class="inline-block px-2 py-0.5 rounded-full text-[10px] {{ $s->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ $s->is_active ? 'Activo' : 'Inactivo' }}</span></td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('admin.bookings.services.edit', $s) }}" class="text-pink-600 text-xs uppercase tracking-widest font-semibold">Editar</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-12 text-center text-gray-500">Sin servicios. Crea el primero.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
