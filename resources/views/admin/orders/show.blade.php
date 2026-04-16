@extends('admin.layouts.app')
@section('title', 'Pedido '.$order->reference)
@section('page_title', 'Pedido '.$order->reference)

@section('content')
<div class="grid lg:grid-cols-[1fr_340px] gap-6">
    <div class="space-y-6">
        <section class="bg-white border border-pink-200 rounded-xl p-6">
            <h2 class="font-heading text-lg text-pink-700 mb-4">Artículos</h2>
            <table class="w-full text-sm">
                <thead class="text-left text-xs uppercase tracking-widest text-gray-500 border-b border-pink-100">
                    <tr>
                        <th class="py-2">Producto</th>
                        <th>SKU</th>
                        <th class="text-right">Cant.</th>
                        <th class="text-right">Unit</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->lines as $line)
                        <tr class="border-b border-pink-50 last:border-0">
                            <td class="py-3">{{ $line->description }}</td>
                            <td class="text-xs font-mono text-gray-500">{{ $line->identifier }}</td>
                            <td class="text-right">{{ $line->quantity }}</td>
                            <td class="text-right">{{ number_format($line->unit_price / 100, 2, ',', '.') }}</td>
                            <td class="text-right font-semibold">{{ number_format($line->total / 100, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t-2 border-pink-200 text-sm">
                    <tr><td colspan="4" class="text-right py-2 text-gray-600">Subtotal</td><td class="text-right">{{ number_format($order->sub_total / 100, 2, ',', '.') }}</td></tr>
                    <tr><td colspan="4" class="text-right py-1 text-gray-600">Envío</td><td class="text-right">{{ number_format($order->shipping_total / 100, 2, ',', '.') }}</td></tr>
                    <tr><td colspan="4" class="text-right py-1 text-gray-600">IVA</td><td class="text-right">{{ number_format($order->tax_total / 100, 2, ',', '.') }}</td></tr>
                    <tr><td colspan="4" class="text-right py-2 font-bold">Total</td><td class="text-right font-bold text-pink-700 text-lg">{{ number_format($order->total / 100, 2, ',', '.') }} {{ $order->currency_code === 'EUR' ? '€' : '$' }}</td></tr>
                </tfoot>
            </table>
        </section>

        @if($order->billingAddress)
            <section class="bg-white border border-pink-200 rounded-xl p-6">
                <h2 class="font-heading text-lg text-pink-700 mb-4">Dirección de facturación</h2>
                @php $a = $order->billingAddress; @endphp
                <div class="text-sm text-gray-700 space-y-1">
                    <p><strong>{{ $a->first_name }} {{ $a->last_name }}</strong></p>
                    <p>{{ $a->line_one }} @if($a->line_two) / {{ $a->line_two }} @endif</p>
                    <p>{{ $a->postcode }} {{ $a->city }} @if($a->state) ({{ $a->state }}) @endif</p>
                    @if($a->contact_email) <p class="text-gray-500">{{ $a->contact_email }}</p>@endif
                    @if($a->contact_phone) <p class="text-gray-500">{{ $a->contact_phone }}</p>@endif
                </div>
            </section>
        @endif
    </div>

    <aside class="space-y-6">
        <section class="bg-white border border-pink-200 rounded-xl p-6">
            <h3 class="font-heading text-base text-pink-700 mb-4">Estado</h3>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="space-y-3">
                @csrf @method('PUT')
                <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs uppercase tracking-widest py-2 rounded-md">Actualizar</button>
            </form>
        </section>

        <section class="bg-white border border-pink-200 rounded-xl p-6 text-sm space-y-2">
            <h3 class="font-heading text-base text-pink-700 mb-3">Detalles</h3>
            <div class="flex justify-between"><span class="text-gray-500">Referencia</span><span class="font-mono">{{ $order->reference }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Moneda</span><span>{{ $order->currency_code }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Fecha</span><span>{{ $order->placed_at?->format('d/m/Y H:i') }}</span></div>
            @if($order->meta && $order->meta['payment_method_selected'] ?? null)
                <div class="flex justify-between"><span class="text-gray-500">Pago</span><span>{{ $order->meta['payment_method_selected'] }}</span></div>
            @endif
            @if($order->meta && $order->meta['wc_id'] ?? null)
                <div class="flex justify-between"><span class="text-gray-500">WC ID</span><span class="font-mono">{{ $order->meta['wc_id'] }}</span></div>
            @endif
        </section>

        @if($order->customer)
            <section class="bg-white border border-pink-200 rounded-xl p-6 text-sm">
                <h3 class="font-heading text-base text-pink-700 mb-3">Cliente</h3>
                <p class="font-semibold">{{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
                @if($order->customer->meta['email'] ?? null)
                    <p class="text-gray-500 text-xs mt-1">{{ $order->customer->meta['email'] }}</p>
                @endif
            </section>
        @endif
    </aside>
</div>
@endsection
