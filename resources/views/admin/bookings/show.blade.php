@extends('admin.layouts.app')
@section('title', 'Reserva #'.$booking->reference)
@section('page_title', 'Reserva #'.$booking->reference)

@section('content')
<div class="grid lg:grid-cols-[1fr_320px] gap-6">
    <div class="space-y-6">
        <section class="bg-white border border-pink-200 rounded-xl p-6">
            <h2 class="font-heading text-lg text-pink-700 mb-4">Datos de la reserva</h2>
            <dl class="grid md:grid-cols-2 gap-4 text-sm">
                <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Servicio</dt><dd class="font-semibold">{{ $booking->service?->name ?? '—' }}</dd></div>
                <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Precio</dt><dd class="font-semibold text-pink-700">{{ number_format($booking->finalPrice(), 2, ',', '.') }} €</dd></div>
                <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Fecha preferida</dt><dd>{{ $booking->preferred_date?->format('d/m/Y') ?? 'Flexible' }} {{ $booking->preferred_time ?? '' }}</dd></div>
                <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Método</dt><dd>{{ \App\Models\BookingService::deliveryMethods()[$booking->delivery_method] ?? $booking->delivery_method }}</dd></div>
                <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Creada</dt><dd>{{ $booking->created_at->format('d/m/Y H:i') }}</dd></div>
                @if($booking->coupon_code)<div><dt class="text-gray-500 text-xs uppercase tracking-widest">Cupón</dt><dd class="font-mono">{{ $booking->coupon_code }} (-{{ number_format($booking->discount, 2, ',', '.') }}€)</dd></div>@endif
            </dl>
            @if($booking->customer_notes)
                <div class="mt-4 p-3 bg-pink-50 rounded-md">
                    <p class="text-xs uppercase tracking-widest text-gray-600 mb-1">Nota del cliente</p>
                    <p class="text-sm text-gray-700">{{ $booking->customer_notes }}</p>
                </div>
            @endif
        </section>

        <section class="bg-white border border-pink-200 rounded-xl p-6">
            <h2 class="font-heading text-lg text-pink-700 mb-4">Cliente</h2>
            <dl class="grid md:grid-cols-2 gap-4 text-sm">
                <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Nombre</dt><dd class="font-semibold">{{ $booking->customer_name }}</dd></div>
                <div><dt class="text-gray-500 text-xs uppercase tracking-widest">Email</dt><dd><a href="mailto:{{ $booking->customer_email }}" class="text-pink-600 hover:underline">{{ $booking->customer_email }}</a></dd></div>
                @if($booking->customer_phone)<div><dt class="text-gray-500 text-xs uppercase tracking-widest">Teléfono</dt><dd>{{ $booking->customer_phone }}</dd></div>@endif
            </dl>
            <div class="flex gap-2 mt-4">
                <a href="{{ $booking->whatsappUrl() }}" target="_blank" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white text-xs uppercase tracking-widest font-semibold px-4 py-2 rounded-md">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.82 11.82 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/></svg>
                    WhatsApp
                </a>
                <a href="mailto:{{ $booking->customer_email }}" class="inline-flex items-center gap-2 bg-pink-500 hover:bg-pink-600 text-white text-xs uppercase tracking-widest font-semibold px-4 py-2 rounded-md">Email</a>
            </div>
        </section>
    </div>

    <aside class="space-y-4">
        <section class="bg-white border border-pink-200 rounded-xl p-6">
            <h2 class="font-heading text-pink-700 mb-4">Cambiar estado</h2>
            <form method="POST" action="{{ route('admin.bookings.status', $booking) }}">
                @csrf @method('PUT')
                <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 mb-3 text-sm">
                    @foreach(\App\Models\Booking::STATUSES as $k => $label)
                        <option value="{{ $k }}" @selected($booking->status === $k)>{{ $label }}</option>
                    @endforeach
                </select>
                <textarea name="admin_notes" rows="3" placeholder="Nota para el cliente (opcional)..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-3">{{ $booking->admin_notes }}</textarea>
                <button type="submit" class="w-full bg-gradient-to-br from-pink-600 to-pink-500 text-white font-bold uppercase tracking-widest text-xs py-2.5 rounded-md">Actualizar</button>
            </form>
            <p class="text-[10px] text-gray-400 mt-2">Al cambiar estado se envía email al cliente automáticamente.</p>
        </section>

        <section class="bg-white border border-pink-200 rounded-xl p-6 text-sm space-y-2">
            <p><span class="text-gray-500">Referencia:</span> <span class="font-mono font-bold text-pink-700">#{{ $booking->reference }}</span></p>
            <p><span class="text-gray-500">Estado actual:</span> {{ \App\Models\Booking::STATUSES[$booking->status] }}</p>
            <p><span class="text-gray-500">Pago:</span> {{ \App\Models\Booking::PAYMENT_STATUSES[$booking->payment_status] }}</p>
            @if($booking->accepted_at)<p><span class="text-gray-500">Aceptada:</span> {{ $booking->accepted_at->format('d/m/Y H:i') }}</p>@endif
            @if($booking->completed_at)<p><span class="text-gray-500">Completada:</span> {{ $booking->completed_at->format('d/m/Y H:i') }}</p>@endif
            <p><span class="text-gray-500">IP:</span> <span class="font-mono text-xs">{{ $booking->ip }}</span></p>
        </section>

        <a href="{{ route('admin.bookings.index') }}" class="block text-center text-xs text-gray-500 hover:text-pink-600 uppercase tracking-widest font-semibold">← Volver a reservas</a>
    </aside>
</div>
@endsection
