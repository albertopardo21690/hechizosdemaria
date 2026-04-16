@extends('admin.layouts.app')
@section('title', 'Pedidos')
@section('page_title', 'Pedidos ('.$orders->total().')')

@section('content')
<form method="GET" class="flex gap-2 mb-6">
    <input type="text" name="q" value="{{ $q }}" placeholder="Buscar por referencia o cliente..." class="flex-1 max-w-md border border-gray-300 rounded-md px-4 py-2 focus:border-pink-500 focus:outline-none">
    <select name="status" class="border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
        <option value="">Todos los estados</option>
        @foreach($statuses as $key => $label)
            <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-pink-100 text-pink-700 border border-pink-300 px-4 rounded-md text-sm uppercase tracking-widest hover:bg-pink-200">Filtrar</button>
</form>

<div class="bg-white border border-pink-200 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-pink-50 text-left text-xs uppercase tracking-widest text-gray-600">
            <tr>
                <th class="px-4 py-3">Ref</th>
                <th class="px-4 py-3">Cliente</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Estado</th>
                <th class="px-4 py-3">Fecha</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $o)
                <tr class="border-t border-pink-100 hover:bg-pink-50/30">
                    <td class="px-4 py-3 font-mono text-pink-700 font-semibold">
                        <a href="{{ route('admin.orders.show', $o) }}" class="hover:underline">{{ $o->reference }}</a>
                    </td>
                    <td class="px-4 py-3">
                        @if($o->customer)
                            {{ $o->customer->first_name }} {{ $o->customer->last_name }}
                        @else
                            <span class="text-gray-500">Invitado</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-semibold">{{ number_format($o->total->decimal, 2, ',', '.') }} {{ $o->currency_code === 'EUR' ? '€' : '$' }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-pink-50 text-pink-700">{{ $statuses[$o->status] ?? $o->status }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $o->placed_at?->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.orders.show', $o) }}" class="text-pink-600 text-xs uppercase tracking-widest font-semibold">Ver</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-12 text-center text-gray-500">Sin pedidos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $orders->links() }}</div>
@endsection
