@extends('layouts.app')
@section('title', 'Mis reservas')
@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <p class="text-pink-500 text-xs tracking-[0.4em] uppercase mb-1">Mi cuenta</p>
    <h1 class="font-heading text-3xl text-pink-700 mb-8">Mis reservas</h1>
    <div class="grid md:grid-cols-[200px_1fr] gap-8">
        @include('front.account._nav')
        <div class="bg-white border border-pink-200 rounded-xl overflow-hidden">
            @forelse($bookings as $b)
                @php $colors = ['pending'=>'bg-yellow-100 text-yellow-700','accepted'=>'bg-green-100 text-green-700','rejected'=>'bg-red-100 text-red-700','completed'=>'bg-blue-100 text-blue-700','cancelled'=>'bg-gray-100 text-gray-600']; @endphp
                <a href="{{ route('account.booking', $b->reference) }}" class="flex items-center justify-between px-5 py-4 border-b border-pink-100 last:border-b-0 hover:bg-pink-50/40 transition">
                    <div>
                        <span class="font-mono text-sm text-pink-700 font-bold">#{{ $b->reference }}</span>
                        <span class="text-gray-700 ml-2">{{ $b->service?->name ?? '—' }}</span>
                        <span class="text-xs text-gray-500 ml-2">{{ $b->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold">{{ number_format($b->finalPrice(), 2, ',', '.') }}€</span>
                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] uppercase tracking-widest {{ $colors[$b->status] ?? 'bg-gray-100' }}">{{ \App\Models\Booking::STATUSES[$b->status] ?? $b->status }}</span>
                    </div>
                </a>
            @empty
                <div class="px-5 py-12 text-center text-gray-500">Aún no tienes reservas. <a href="{{ route('booking') }}" class="text-pink-600 hover:underline">Reservar ahora</a></div>
            @endforelse
            <div class="px-5 py-3">{{ $bookings->links() }}</div>
        </div>
    </div>
</section>
@endsection
