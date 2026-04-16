@extends('admin.layouts.app')
@section('title', $product ? 'Editar producto' : 'Nuevo producto')
@section('page_title', $product ? ($product->attribute_data['name']?->getValue() ?? 'Producto') : 'Nuevo producto')

@section('content')
@php
    $variant = $product?->variants->first();
    $eurPrice = $variant?->prices->firstWhere('currency.code', 'EUR');
    $usdPrice = $variant?->prices->firstWhere('currency.code', 'USD');
    $slug = $product?->urls->where('default', true)->first()?->slug ?? '';
    $name = $product?->attribute_data['name']?->getValue() ?? '';
    $desc = $product?->attribute_data['description']?->getValue() ?? '';
@endphp

<form method="POST" action="{{ $product ? route('admin.products.update', $product) : route('admin.products.store') }}" class="grid lg:grid-cols-[1fr_340px] gap-6">
    @csrf
    @if($product) @method('PUT') @endif

    <div class="space-y-6">
        <section class="bg-white border border-pink-200 rounded-xl p-6">
            <h2 class="font-heading text-lg text-pink-700 mb-4">Información</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Nombre *</label>
                    <input type="text" name="name" value="{{ old('name', $name) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                    @error('name')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Slug *</label>
                    <input type="text" name="slug" value="{{ old('slug', $slug) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none font-mono text-sm">
                    <p class="text-xs text-gray-500 mt-1">URL: /tienda/<strong>{{ old('slug', $slug) ?: 'ejemplo' }}</strong></p>
                    @error('slug')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Descripción</label>
                    <textarea name="description" rows="12" data-rich-editor class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">{!! old('description', $desc) !!}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Editor con formato: negrita, listas, enlaces, encabezados. Limpia automáticamente HTML pegado desde Word/Google Docs.</p>
                </div>
            </div>
        </section>

        @if($product)
            <section class="bg-white border border-pink-200 rounded-xl p-6">
                <h2 class="font-heading text-lg text-pink-700 mb-4">Imágenes</h2>
                <form method="POST" action="{{ route('admin.products.upload-image', $product) }}" enctype="multipart/form-data" class="mb-4 flex gap-2 items-center">
                    @csrf
                    <input type="file" name="file" required accept="image/*" class="flex-1 text-sm file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-pink-500 file:text-white file:text-xs file:uppercase file:tracking-widest file:font-semibold hover:file:bg-pink-600 file:cursor-pointer cursor-pointer border border-gray-200 rounded-md p-1">
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs uppercase tracking-widest font-semibold px-4 py-2 rounded-md">Añadir</button>
                </form>
                <div class="grid grid-cols-4 gap-3">
                    @foreach($product->getMedia('images') as $media)
                        <div class="relative group aspect-square bg-pink-50 rounded-lg overflow-hidden border border-pink-200">
                            <img src="{{ $media->getUrl('small') }}" class="w-full h-full object-cover">
                            <form method="POST" action="{{ route('admin.products.delete-image', [$product, $media->id]) }}" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                                @csrf
                                <button type="submit" onclick="return confirm('Eliminar imagen?')" class="bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center text-sm">&times;</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <aside class="space-y-6">
        <section class="bg-white border border-pink-200 rounded-xl p-6">
            <h3 class="font-heading text-base text-pink-700 mb-4">Estado</h3>
            <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                <option value="published" @selected(old('status', $product?->status) === 'published')>Publicado</option>
                <option value="draft" @selected(old('status', $product?->status) === 'draft')>Borrador</option>
            </select>
        </section>

        <section class="bg-white border border-pink-200 rounded-xl p-6">
            <h3 class="font-heading text-base text-pink-700 mb-4">Precios y stock</h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Precio EUR *</label>
                    <input type="number" step="0.01" min="0" name="price_eur" value="{{ old('price_eur', $eurPrice?->price->decimal) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Precio USD</label>
                    <input type="number" step="0.01" min="0" name="price_usd" value="{{ old('price_usd', $usdPrice?->price->decimal) }}" placeholder="auto 1.08x" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $variant?->sku) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none font-mono text-sm">
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Stock</label>
                    <input type="number" min="0" name="stock" value="{{ old('stock', $variant?->stock ?? 999) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                </div>
            </div>
        </section>

        <section class="bg-white border border-pink-200 rounded-xl p-6">
            <h3 class="font-heading text-base text-pink-700 mb-4">Colecciones</h3>
            <div class="space-y-1 max-h-72 overflow-y-auto">
                @foreach($collections as $c)
                    <label class="flex items-center gap-2 text-sm py-1 hover:bg-pink-50/50 px-2 rounded">
                        <input type="checkbox" name="collections[]" value="{{ $c->id }}" @checked(in_array($c->id, old('collections', $selectedCollections))) class="accent-pink-500">
                        {{ $c->attribute_data['name']?->getValue() ?? '-' }}
                    </label>
                @endforeach
            </div>
        </section>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 hover:to-pink-400 text-white font-bold uppercase tracking-widest text-sm py-3 rounded-md">
                {{ $product ? 'Guardar' : 'Crear producto' }}
            </button>
        </div>
        @if($product)
            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Eliminar este producto permanentemente?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full border border-red-300 text-red-600 hover:bg-red-50 text-xs uppercase tracking-widest font-semibold py-2.5 rounded-md">Eliminar producto</button>
            </form>
        @endif
    </aside>
</form>
@endsection
