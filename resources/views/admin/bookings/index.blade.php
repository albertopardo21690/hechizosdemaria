@extends('admin.layouts.app')
@section('title', 'Reservas')
@section('page_title', 'Reservas ('.$bookings->total().')')

@section('content')
<div class="flex items-center gap-2 mb-4 text-sm flex-wrap">
    <a href="{{ route('admin.bookings.index') }}" class="px-3 py-1.5 rounded border {{ !request('status') ? 'border-pink-500 bg-pink-50 text-pink-700' : 'border-pink-200 text-gray-600 hover:bg-pink-50' }}">
        Todas ({{ $counts->sum() }})
    </a>
    @foreach(\App\Models\Booking::STATUSES as $key => $label)
        <a href="{{ route('admin.bookings.index', ['status' => $key]) }}" class="px-3 py-1.5 rounded border {{ request('status') === $key ? 'border-pink-500 bg-pink-50 text-pink-700' : 'border-pink-200 text-gray-600 hover:bg-pink-50' }}">
            {{ $label }} ({{ $counts[$key] ?? 0 }})
        </a>
    @endforeach
</div>

<form method="GET" class="mb-4">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por nombre, email o referencia..." class="w-full max-w-md border border-pink-200 rounded-md px-3 py-2 text-sm focus:border-pink-500 focus:outline-none">
</form>

<div class="bg-white border border-pink-200 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-pink-50 text-left text-xs uppercase tracking-widest text-gray-600">
            <tr><th class="px-4 py-3">Ref</th><th class="px-4 py-3">Servicio</th><th class="px-4 py-3">Cliente</th><th class="px-4 py-3">Fecha pref.</th><th class="px-4 py-3">Estado</th><th class="px-4 py-3">Pago</th><th class="px-4 py-3"></th></tr>
        </thead>
        <tbody>
            @forelse($bookings as $b)
                @php
                    $statusColors = ['pending' => 'bg-yellow-100 text-yellow-700', 'accepted' => 'bg-green-100 text-green-700', 'rejected' => 'bg-red-100 text-red-700', 'completed' => 'bg-blue-100 text-blue-700', 'cancelled' => 'bg-gray-100 text-gray-600', 'no_show' => 'bg-orange-100 text-orange-700'];
                @endphp
                <tr class="border-t border-pink-100 hover:bg-pink-50/30">
                    <td class="px-4 py-3 font-mono text-xs text-pink-700 font-bold">#{{ $b->reference }}</td>
                    <td class="px-4 py-3">{{ $b->service?->name ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <div class="font-semibold">{{ $b->customer_name }}</div>
                        <div class="text-xs text-gray-500">{{ $b->customer_email }}</div>
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $b->preferred_date?->format('d/m/Y') ?? 'Flexible' }}</td>
                    <td class="px-4 py-3"><span class="inline-block px-2 py-0.5 rounded-full text-[10px] uppercase tracking-widest {{ $statusColors[$b->status] ?? 'bg-gray-100' }}">{{ \App\Models\Booking::STATUSES[$b->status] ?? $b->status }}</span></td>
                    <td class="px-4 py-3"><span class="text-xs {{ $b->payment_status === 'paid' ? 'text-green-600' : 'text-gray-500' }}">{{ \App\Models\Booking::PAYMENT_STATUSES[$b->payment_status] ?? $b->payment_status }}</span></td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('admin.bookings.show', $b) }}" class="text-pink-600 text-xs uppercase tracking-widest font-semibold">Ver</a></td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-12 text-center text-gray-500">Sin reservas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $bookings->links() }}</div>
@endsection
