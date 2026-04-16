@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white border border-pink-200 rounded-xl p-6">
        <div class="text-xs uppercase tracking-widest text-gray-500 mb-2">Productos</div>
        <div class="font-heading text-3xl text-pink-700">{{ $productsCount }}</div>
    </div>
    <div class="bg-white border border-pink-200 rounded-xl p-6">
        <div class="text-xs uppercase tracking-widest text-gray-500 mb-2">Pedidos totales</div>
        <div class="font-heading text-3xl text-pink-700">{{ $ordersCount }}</div>
        <div class="text-xs text-amber-600 mt-1">{{ $pendingOrders }} pendientes</div>
    </div>
    <div class="bg-white border border-pink-200 rounded-xl p-6">
        <div class="text-xs uppercase tracking-widest text-gray-500 mb-2">Clientes</div>
        <div class="font-heading text-3xl text-pink-700">{{ $customersCount }}</div>
    </div>
    <div class="bg-white border border-pink-200 rounded-xl p-6">
        <div class="text-xs uppercase tracking-widest text-gray-500 mb-2">Paginas / Testimonios</div>
        <div class="font-heading text-3xl text-pink-700">{{ $pagesCount }} / {{ $testimonialsCount }}</div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4 mb-8">
    <div class="bg-white border border-pink-200 rounded-xl p-6">
        <div class="text-xs uppercase tracking-widest text-gray-500 mb-2">Facturado EUR</div>
        <div class="font-heading text-3xl text-green-600">{{ number_format($revenueEur, 2, ',', '.') }} €</div>
        <div class="text-xs text-gray-500 mt-1">{{ $revenueEurCount }} pedidos cobrados</div>
    </div>
    <div class="bg-white border border-pink-200 rounded-xl p-6">
        <div class="text-xs uppercase tracking-widest text-gray-500 mb-2">Facturado USD</div>
        <div class="font-heading text-3xl text-green-600">${{ number_format($revenueUsd, 2, '.', ',') }}</div>
        <div class="text-xs text-gray-500 mt-1">{{ $revenueUsdCount }} pedidos cobrados</div>
    </div>
</div>

<div class="bg-white border border-pink-200 rounded-xl p-6">
    <h2 class="font-heading text-xl text-pink-700 mb-4">Ultimos pedidos</h2>
    @if($recentOrders->count())
        <table class="w-full text-sm">
            <thead class="text-left text-xs uppercase tracking-widest text-gray-500 border-b border-pink-100">
                <tr>
                    <th class="py-2">Ref</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                    <tr class="border-b border-pink-50 last:border-0">
                        <td class="py-2 font-mono text-pink-700">{{ $order->reference }}</td>
                        <td><span class="inline-block px-2 py-0.5 rounded-full text-xs bg-pink-50 text-pink-700">{{ $order->status }}</span></td>
                        <td>{{ number_format($order->total->decimal, 2, ',', '.') }} {{ $order->currency_code === 'EUR' ? '€' : '$' }}</td>
                        <td class="text-gray-500">{{ $order->placed_at?->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-500 text-sm">Aun no hay pedidos.</p>
    @endif
</div>
@endsection
