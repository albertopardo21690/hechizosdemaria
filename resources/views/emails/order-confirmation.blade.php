<x-mail::message>
# Gracias por tu pedido

Tu pedido **{{ $order->reference }}** ha sido confirmado. Maria Jose se pondra en contacto contigo muy pronto.

## Resumen

@foreach($lines as $line)
- **{{ $line->description }}** x{{ $line->quantity }} — {{ number_format($line->subTotal->decimal ?? 0, 2, ',', '.') }} {{ $order->currency_code === 'EUR' ? '€' : '$' }}
@endforeach

---

**Subtotal:** {{ number_format($order->subTotal->decimal, 2, ',', '.') }} {{ $order->currency_code === 'EUR' ? '€' : '$' }}
**Envio:** {{ number_format($order->shippingTotal->decimal, 2, ',', '.') }} {{ $order->currency_code === 'EUR' ? '€' : '$' }}
**Total:** {{ number_format($order->total->decimal, 2, ',', '.') }} {{ $order->currency_code === 'EUR' ? '€' : '$' }}

@if($billing)
## Envio a

{{ $billing->first_name }} {{ $billing->last_name }}
{{ $billing->line_one }}@if($billing->line_two), {{ $billing->line_two }}@endif
{{ $billing->postcode }} {{ $billing->city }}@if($billing->state), {{ $billing->state }}@endif
@endif

<x-mail::button :url="route('payment.success', $order->reference)">
Ver detalles del pedido
</x-mail::button>

Si tienes cualquier duda, responde a este correo o escribeme por WhatsApp al +34 695 619 087.

Bendecida por las estrellas,<br>
**Maria Jose Gomez** — Hechizos de Maria
</x-mail::message>
