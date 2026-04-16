@extends('admin.layouts.app')
@section('title', 'Colecciones')
@section('page_title', 'Colecciones ('.$collections->total().')')

@section('content')
<div class="mb-6 text-right">
    <a href="{{ route('admin.collections.create') }}" class="bg-gradient-to-br from-pink-600 to-pink-500 text-white font-semibold text-sm uppercase tracking-widest px-5 py-2.5 rounded-md">+ Nueva colección</a>
</div>

<div class="bg-white border border-pink-200 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-pink-50 text-left text-xs uppercase tracking-widest text-gray-600">
            <tr><th class="px-4 py-3">Nombre</th><th class="px-4 py-3">Slug</th><th class="px-4 py-3">Productos</th><th class="px-4 py-3"></th></tr>
        </thead>
        <tbody>
            @foreach($collections as $c)
                @php $slug = $c->urls->where('default', true)->first()?->slug ?? $c->urls->first()?->slug; @endphp
                <tr class="border-t border-pink-100 hover:bg-pink-50/30">
                    <td class="px-4 py-3 font-semibold"><a href="{{ route('admin.collections.edit', $c) }}" class="hover:text-pink-600">{{ $c->attribute_data['name']?->getValue() ?? '-' }}</a></td>
                    <td class="px-4 py-3 text-xs font-mono text-gray-600">/{{ $slug }}</td>
                    <td class="px-4 py-3 text-pink-700 font-semibold">{{ $c->products_count }}</td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('admin.collections.edit', $c) }}" class="text-pink-600 text-xs uppercase tracking-widest font-semibold">Editar</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $collections->links() }}</div>
@endsection
