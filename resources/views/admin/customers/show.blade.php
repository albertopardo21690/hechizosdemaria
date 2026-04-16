@extends('admin.layouts.app')
@section('title', $customer->first_name.' '.$customer->last_name)
@section('page_title', $customer->first_name.' '.$customer->last_name)

@section('content')
<div class="grid lg:grid-cols-[300px_1fr] gap-6">
    <section class="bg-white border border-pink-200 rounded-xl p-6 h-fit">
        <div class="text-center mb-4">
            <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-white text-2xl font-bold mb-3">
                {{ strtoupper(substr($customer->first_name, 0, 1).substr($customer->last_name, 0, 1)) }}
            </div>
            <h3 class="font-heading text-lg text-pink-700">{{ $customer->first_name }} {{ $customer->last_name }}</h3>
            @if($customer->company_name)<p class="text-sm text-gray-500">{{ $customer->company_name }}</p>@endif
        </div>
        <dl class="text-sm space-y-2 border-t border-pink-100 pt-4">
            <div class="flex justify-between"><dt class="text-gray-500">Email</dt><dd>{{ $customer->meta['email'] ?? '—' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Ref</dt><dd class="font-mono text-xs">{{ $customer->account_ref }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Alta</dt><dd>{{ $customer->created_at?->format('d/m/Y') }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Pedidos</dt><dd class="font-semibold text-pink-700">{{ $customer->orders->count() }}</dd></div>
        </dl>
    </section>

    <section class="bg-white border border-pink-200 rounded-xl p-6">
        <h2 class="font-heading text-lg text-pink-700 mb-4">Pedidos</h2>
        @if($customer->orders->count())
            <table class="w-full text-sm">
                <thead class="text-left text-xs uppercase tracking-widest text-gray-500 border-b border-pink-100">
                    <tr><th class="py-2">Ref</th><th>Estado</th><th class="text-right">Total</th><th>Fecha</th></tr>
                </thead>
                <tbody>
                    @foreach($customer->orders as $o)
                        <tr class="border-b border-pink-50 last:border-0">
                            <td class="py-2"><a href="{{ route('admin.orders.show', $o) }}" class="font-mono text-pink-700 hover:underline">{{ $o->reference }}</a></td>
                            <td><span class="inline-block px-2 py-0.5 rounded-full text-xs bg-pink-50 text-pink-700">{{ $o->status }}</span></td>
                            <td class="text-right font-semibold">{{ number_format($o->total->decimal, 2, ',', '.') }} {{ $o->currency_code === 'EUR' ? '€' : '$' }}</td>
                            <td class="text-gray-500 text-xs">{{ $o->placed_at?->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500 text-sm">Sin pedidos.</p>
        @endif
    </section>
</div>
@endsection
