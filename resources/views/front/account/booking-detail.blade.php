@extends('layouts.app')
@section('title', 'Reserva #'.$booking->reference)
@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    <p class="text-pink-500 text-xs tracking-[0.4em] uppercase mb-1">Mi cuenta</p>
    <h1 class="font-heading text-3xl text-pink-700 mb-8">Reserva #{{ $booking->reference }}</h1>
    <div class="grid md:grid-cols-[200px_1fr] gap-8">
        @include('front.account._nav')
        <div class="space-y-6">
            @php $colors = ['pending'=>'bg-yellow-100 text-yellow-700 border-yellow-200','accepted'=>'bg-green-100 text-green-700 border-green-200','rejected'=>'bg-red-100 text-red-700 border-red-200','completed'=>'bg-blue-100 text-blue-700 border-blue-200','cancelled'=>'bg-gray-100 text-gray-600 border-gray-200']; @endphp
            <div class="p-4 rounded-xl border text-center {{ $colors[$booking->status] ?? 'bg-gray-100 border-gray-200' }}">
                <span class="text-xs uppercase tracking-widest font-bold">{{ \App\Models\Booking::STATUSES[$booking->status] ?? $booking->status }}</span>
            </div>

            <div class="bg-white border border-pink-200 rounded-xl p-6">
                <h2 class="font-heading text-lg text-pink-700 mb-4">Detalles</h2>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Servicio</dt><dd class="font-semibold">{{ $booking->service?->name }}</dd></div>
                    <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Precio</dt><dd class="font-semibold text-pink-700">{{ number_format($booking->finalPrice(), 2, ',', '.') }}€</dd></div>
                    <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Fecha preferida</dt><dd>{{ $booking->preferred_date?->format('d/m/Y') ?? 'Flexible' }} {{ $booking->preferred_time }}</dd></div>
                    <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Método</dt><dd>{{ \App\Models\BookingService::deliveryMethods()[$booking->delivery_method] ?? $booking->delivery_method }}</dd></div>
                    <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Creada</dt><dd>{{ $booking->created_at->format('d/m/Y H:i') }}</dd></div>
                    <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Pago</dt><dd>{{ \App\Models\Booking::PAYMENT_STATUSES[$booking->payment_status] ?? $booking->payment_status }}</dd></div>
                </dl>
                @if($booking->admin_notes)
                    <div class="mt-4 p-3 bg-pink-50 rounded-md">
                        <p class="text-xs uppercase tracking-widest text-gray-600 mb-1">Mensaje de María José</p>
                        <p class="text-sm text-gray-700">{{ $booking->admin_notes }}</p>
                    </div>
                @endif
            </div>

            <div class="flex flex-wrap gap-3">
                @if($booking->status === 'accepted')
                    <a href="{{ $booking->whatsappUrl() }}" target="_blank" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold text-xs uppercase tracking-widest px-5 py-2.5 rounded-md">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.82 11.82 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/></svg>
                        WhatsApp con María José
                    </a>
                @endif
                @if(in_array($booking->status, ['pending', 'accepted']))
                    <form method="POST" action="{{ route('account.booking.cancel', $booking->reference) }}" onsubmit="return confirm('¿Cancelar esta reserva?')">
                        @csrf
                        <button type="submit" class="border border-red-300 text-red-600 hover:bg-red-50 text-xs uppercase tracking-widest font-semibold px-5 py-2.5 rounded-md">Cancelar reserva</button>
                    </form>
                @endif
            </div>

            <a href="{{ route('account.bookings') }}" class="text-pink-600 hover:text-pink-800 text-xs uppercase tracking-widest font-semibold">← Volver a reservas</a>
        </div>
    </div>
</section>
@endsection
