@extends('layouts.app')
@section('title', 'Mi cuenta')
@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <p class="text-pink-500 text-xs tracking-[0.4em] uppercase">Mi cuenta</p>
            <h1 class="font-heading text-3xl text-pink-700">Hola, {{ $customer->name }}</h1>
        </div>
        <form method="POST" action="{{ route('customer.logout') }}">
            @csrf
            <button type="submit" class="text-xs uppercase tracking-widest text-gray-500 hover:text-pink-600 font-semibold">Cerrar sesión</button>
        </form>
    </div>

    <div class="grid md:grid-cols-[200px_1fr] gap-8">
        @include('front.account._nav')

        <div class="space-y-6">
            <div class="bg-white border border-pink-200 rounded-xl p-6">
                <h2 class="font-heading text-lg text-pink-700 mb-4">Resumen</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center">
                    <div class="bg-pink-50 rounded-lg p-4">
                        <p class="text-2xl font-bold text-pink-700">{{ $orders->count() }}</p>
                        <p class="text-xs text-gray-600 uppercase tracking-widest">Pedidos</p>
                    </div>
                    <div class="bg-pink-50 rounded-lg p-4">
                        <p class="text-2xl font-bold text-pink-700">{{ $customer->created_at->diffForHumans() }}</p>
                        <p class="text-xs text-gray-600 uppercase tracking-widest">Cliente desde</p>
                    </div>
                </div>
            </div>

            @if($orders->count())
                <div class="bg-white border border-pink-200 rounded-xl p-6">
                    <h2 class="font-heading text-lg text-pink-700 mb-4">Últimos pedidos</h2>
                    @foreach($orders->take(5) as $order)
                        <a href="{{ route('account.order', $order->reference) }}" class="flex items-center justify-between py-3 border-b border-pink-100 last:border-b-0 hover:bg-pink-50/40 -mx-2 px-2 rounded transition">
                            <div>
                                <span class="font-mono text-sm text-pink-700 font-bold">#{{ $order->reference }}</span>
                                <span class="text-xs text-gray-500 ml-2">{{ $order->placed_at?->format('d/m/Y') }}</span>
                            </div>
                            <div class="text-right">
                                <span class="font-semibold">{{ number_format($order->total->decimal, 2, ',', '.') }} €</span>
                                <span class="text-xs text-gray-500 ml-2">{{ $order->status }}</span>
                            </div>
                        </a>
                    @endforeach
                    @if($orders->count() > 5)
                        <a href="{{ route('account.orders') }}" class="block text-center text-xs text-pink-600 hover:text-pink-800 uppercase tracking-widest font-semibold mt-4">Ver todos los pedidos →</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
