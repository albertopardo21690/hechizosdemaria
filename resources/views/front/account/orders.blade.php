@extends('layouts.app')
@section('title', 'Mis pedidos')
@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <p class="text-pink-500 text-xs tracking-[0.4em] uppercase mb-1">Mi cuenta</p>
    <h1 class="font-heading text-3xl text-pink-700 mb-8">Mis pedidos</h1>

    <div class="grid md:grid-cols-[200px_1fr] gap-8">
        @include('front.account._nav')

        <div class="bg-white border border-pink-200 rounded-xl overflow-hidden">
            @forelse($orders as $order)
                <a href="{{ route('account.order', $order->reference) }}" class="flex items-center justify-between px-5 py-4 border-b border-pink-100 last:border-b-0 hover:bg-pink-50/40 transition">
                    <div>
                        <span class="font-mono text-sm text-pink-700 font-bold">#{{ $order->reference }}</span>
                        <span class="text-xs text-gray-500 ml-2">{{ $order->placed_at?->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="text-right">
                        <span class="font-semibold">{{ number_format($order->total->decimal, 2, ',', '.') }} €</span>
                        <span class="inline-block ml-2 text-[10px] uppercase tracking-widest px-2 py-0.5 rounded-full {{ $order->status === 'payment-received' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ $order->status }}</span>
                    </div>
                </a>
            @empty
                <div class="px-5 py-12 text-center text-gray-500">Aún no tienes pedidos.</div>
            @endforelse
            <div class="px-5 py-3">{{ $orders->links() }}</div>
        </div>
    </div>
</section>
@endsection
