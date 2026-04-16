@extends('admin.layouts.app')
@section('title', 'Clientes')
@section('page_title', 'Clientes ('.$customers->total().')')

@section('content')
<form method="GET" class="flex gap-2 mb-6">
    <input type="text" name="q" value="{{ $q }}" placeholder="Buscar por nombre o email..." class="flex-1 max-w-md border border-gray-300 rounded-md px-4 py-2 focus:border-pink-500 focus:outline-none">
    <button type="submit" class="bg-pink-100 text-pink-700 border border-pink-300 px-4 rounded-md text-sm uppercase tracking-widest hover:bg-pink-200">Buscar</button>
</form>

<div class="bg-white border border-pink-200 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-pink-50 text-left text-xs uppercase tracking-widest text-gray-600">
            <tr><th class="px-4 py-3">Nombre</th><th class="px-4 py-3">Email</th><th class="px-4 py-3">Pedidos</th><th class="px-4 py-3">Alta</th><th class="px-4 py-3"></th></tr>
        </thead>
        <tbody>
            @forelse($customers as $c)
                <tr class="border-t border-pink-100 hover:bg-pink-50/30">
                    <td class="px-4 py-3 font-semibold"><a href="{{ route('admin.customers.show', $c) }}" class="hover:text-pink-600">{{ $c->first_name }} {{ $c->last_name }}</a></td>
                    <td class="px-4 py-3 text-gray-600">{{ $c->meta['email'] ?? '—' }}</td>
                    <td class="px-4 py-3 text-pink-700 font-semibold">{{ $c->orders_count }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $c->created_at?->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('admin.customers.show', $c) }}" class="text-pink-600 text-xs uppercase tracking-widest font-semibold">Ver</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-12 text-center text-gray-500">Sin clientes.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $customers->links() }}</div>
@endsection
