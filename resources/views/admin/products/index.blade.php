@extends('admin.layouts.app')
@section('title', 'Productos')
@section('page_title', 'Productos ('.$products->total().')')

@section('content')
<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <form method="GET" class="flex gap-2 flex-1 max-w-2xl">
        <input type="text" name="q" value="{{ $q }}" placeholder="Buscar por nombre..." class="flex-1 border border-gray-300 rounded-md px-4 py-2 focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
        <select name="status" class="border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
            <option value="">Todos</option>
            <option value="published" @selected($status === 'published')>Publicados</option>
            <option value="draft" @selected($status === 'draft')>Borradores</option>
        </select>
        <button type="submit" class="bg-pink-100 text-pink-700 border border-pink-300 px-4 rounded-md text-sm uppercase tracking-widest hover:bg-pink-200">Filtrar</button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 hover:to-pink-400 text-white font-semibold text-sm uppercase tracking-widest px-5 py-2.5 rounded-md transition">+ Nuevo producto</a>
</div>

<div class="bg-white border border-pink-200 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-pink-50 text-left text-xs uppercase tracking-widest text-gray-600">
            <tr>
                <th class="px-4 py-3 w-16">Img</th>
                <th class="px-4 py-3">Nombre</th>
                <th class="px-4 py-3">SKU</th>
                <th class="px-4 py-3">Precio EUR</th>
                <th class="px-4 py-3">Stock</th>
                <th class="px-4 py-3">Estado</th>
                <th class="px-4 py-3 w-24"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $p)
                @php
                    $name = $p->attribute_data['name']?->getValue() ?? '-';
                    $variant = $p->variants->first();
                    $eurPrice = $variant?->prices->firstWhere('currency.code', 'EUR');
                    $image = $p->getFirstMedia('images');
                @endphp
                <tr class="border-t border-pink-100 hover:bg-pink-50/30">
                    <td class="px-4 py-3">
                        @if($image)
                            <img src="{{ $image->getUrl('small') }}" class="w-10 h-10 object-cover rounded">
                        @else
                            <div class="w-10 h-10 rounded bg-pink-100 flex items-center justify-center text-pink-400">—</div>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-semibold text-gray-900">
                        <a href="{{ route('admin.products.edit', $p) }}" class="hover:text-pink-600">{{ $name }}</a>
                    </td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ $variant?->sku }}</td>
                    <td class="px-4 py-3">{{ $eurPrice ? number_format($eurPrice->price->decimal, 2, ',', '.').' €' : '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $variant?->stock }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs {{ $p->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ $p->status }}</span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.products.edit', $p) }}" class="text-pink-600 hover:text-pink-700 text-xs uppercase tracking-widest font-semibold">Editar</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-12 text-center text-gray-500">Sin productos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
