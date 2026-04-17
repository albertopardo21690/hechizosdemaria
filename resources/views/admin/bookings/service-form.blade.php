@extends('admin.layouts.app')
@section('title', $service ? 'Editar servicio' : 'Nuevo servicio')
@section('page_title', $service ? $service->name : 'Nuevo servicio reservable')

@section('content')
<form method="POST" action="{{ $service ? route('admin.bookings.services.update', $service) : route('admin.bookings.services.store') }}" class="max-w-3xl space-y-6">
    @csrf @if($service) @method('PUT') @endif

    <section class="bg-white border border-pink-200 rounded-xl p-6 space-y-4">
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $service?->name) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                @error('name')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                @include('admin._partials.slug-field', ['source' => 'name', 'slug' => old('slug', $service?->slug ?? ''), 'sourceValue' => old('name', $service?->name ?? ''), 'urlPrefix' => '/reservar/'])
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Precio (€) *</label>
                <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $service?->price ?? 0) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Categoría</label>
                <select name="category" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    @foreach(\App\Models\BookingService::categories() as $k => $v)
                        <option value="{{ $k }}" @selected(old('category', $service?->category ?? 'lectura') === $k)>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Método de entrega</label>
                <select name="delivery_method" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    @foreach(\App\Models\BookingService::deliveryMethods() as $k => $v)
                        <option value="{{ $k }}" @selected(old('delivery_method', $service?->delivery_method ?? 'whatsapp') === $k)>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Duración (minutos, opcional)</label>
                <input type="number" min="0" name="duration_minutes" value="{{ old('duration_minutes', $service?->duration_minutes) }}" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Dejar vacío si no aplica">
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Orden</label>
                <input type="number" name="sort" value="{{ old('sort', $service?->sort ?? 0) }}" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
        </div>
        <div>
            <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Descripción corta</label>
            <input type="text" name="short_description" value="{{ old('short_description', $service?->short_description) }}" maxlength="500" class="w-full border border-gray-300 rounded-md px-3 py-2">
        </div>
        <div>
            <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Descripción completa</label>
            <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2">{{ old('description', $service?->description) }}</textarea>
        </div>
        <div class="flex gap-6 text-sm">
            <label class="flex items-center gap-2"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service?->is_active ?? true)) class="accent-pink-500"> Activo</label>
            <label class="flex items-center gap-2"><input type="hidden" name="requires_payment" value="0"><input type="checkbox" name="requires_payment" value="1" @checked(old('requires_payment', $service?->requires_payment ?? true)) class="accent-pink-500"> Requiere pago</label>
            <label class="flex items-center gap-2"><input type="hidden" name="show_in_catalog" value="0"><input type="checkbox" name="show_in_catalog" value="1" @checked(old('show_in_catalog', $service?->show_in_catalog ?? true)) class="accent-pink-500"> Mostrar en catálogo</label>
        </div>
    </section>

    <div class="flex gap-3">
        <button type="submit" class="bg-gradient-to-br from-pink-600 to-pink-500 text-white font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-md">{{ $service ? 'Guardar' : 'Crear servicio' }}</button>
        @if($service)
            <form method="POST" action="{{ route('admin.bookings.services.destroy', $service) }}" onsubmit="return confirm('¿Eliminar?')">@csrf @method('DELETE')
                <button type="submit" class="border border-red-300 text-red-600 hover:bg-red-50 text-xs uppercase tracking-widest font-semibold px-6 py-3 rounded-md">Eliminar</button>
            </form>
        @endif
    </div>
</form>
@endsection
