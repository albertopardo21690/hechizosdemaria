@extends('admin.layouts.app')
@section('title', $collection ? 'Editar colección' : 'Nueva colección')
@section('page_title', $collection ? ($collection->attribute_data['name']?->getValue() ?? 'Colección') : 'Nueva colección')

@section('content')
@php
    $name = $collection?->attribute_data['name']?->getValue() ?? '';
    $desc = $collection?->attribute_data['description']?->getValue() ?? '';
    $slug = $collection?->urls->where('default', true)->first()?->slug ?? '';
@endphp

<form method="POST" action="{{ $collection ? route('admin.collections.update', $collection) : route('admin.collections.store') }}" class="max-w-3xl space-y-6">
    @csrf @if($collection) @method('PUT') @endif

    <section class="bg-white border border-pink-200 rounded-xl p-6 space-y-4">
        <div>
            <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Nombre *</label>
            <input type="text" name="name" value="{{ old('name', $name) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
        </div>
        <div>
            @include('admin._partials.slug-field', ['source' => 'name', 'slug' => old('slug', $slug), 'sourceValue' => old('name', $name), 'urlPrefix' => '/coleccion/'])
        </div>
        <div>
            <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Descripción</label>
            <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">{{ old('description', $desc) }}</textarea>
        </div>
    </section>

    <div class="flex gap-3">
        <button type="submit" class="bg-gradient-to-br from-pink-600 to-pink-500 text-white font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-md">{{ $collection ? 'Guardar' : 'Crear' }}</button>
        @if($collection)
            <form method="POST" action="{{ route('admin.collections.destroy', $collection) }}" onsubmit="return confirm('Eliminar colección? Se quitarán asociaciones con productos.')">
                @csrf @method('DELETE')
                <button type="submit" class="border border-red-300 text-red-600 hover:bg-red-50 text-xs uppercase tracking-widest font-semibold px-6 py-3 rounded-md">Eliminar</button>
            </form>
        @endif
    </div>
</form>
@endsection
