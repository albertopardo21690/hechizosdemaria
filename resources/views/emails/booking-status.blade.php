@php $b = $booking; $statusLabel = \App\Models\Booking::STATUSES[$b->status] ?? $b->status; @endphp
<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;color:#374151">
    <div style="background:linear-gradient(135deg,#ec4899,#db2777);padding:24px;text-align:center;border-radius:12px 12px 0 0">
        <h1 style="color:#fff;font-size:22px;margin:0">Hechizos de María</h1>
    </div>
    <div style="padding:24px;background:#fff;border:1px solid #fce7f3;border-top:none;border-radius:0 0 12px 12px">
        <p>Hola <strong>{{ $b->customer_name }}</strong>,</p>
        <p>Tu reserva <strong>#{{ $b->reference }}</strong> ha cambiado de estado:</p>
        <div style="background:#fdf2f8;border:1px solid #fce7f3;border-radius:8px;padding:16px;margin:16px 0;text-align:center">
            <p style="font-size:20px;font-weight:bold;color:#be185d;margin:0">{{ $statusLabel }}</p>
        </div>
        <table style="width:100%;font-size:14px;border-collapse:collapse">
            <tr><td style="padding:6px 0;color:#6b7280">Servicio</td><td style="padding:6px 0;font-weight:bold">{{ $b->service?->name ?? '—' }}</td></tr>
            <tr><td style="padding:6px 0;color:#6b7280">Fecha preferida</td><td style="padding:6px 0">{{ $b->preferred_date?->format('d/m/Y') ?? 'Flexible' }}</td></tr>
            @if($b->admin_notes)<tr><td style="padding:6px 0;color:#6b7280">Nota de María José</td><td style="padding:6px 0">{{ $b->admin_notes }}</td></tr>@endif
        </table>
        @if($b->status === 'accepted')
            <p style="margin-top:16px">María José se pondrá en contacto contigo pronto para coordinar los detalles.</p>
            <div style="text-align:center;margin:20px 0">
                <a href="{{ $b->whatsappUrl() }}" style="display:inline-block;background:#22c55e;color:#fff;text-decoration:none;padding:12px 24px;border-radius:8px;font-weight:bold;font-size:14px">Escribir por WhatsApp</a>
            </div>
        @endif
        <p style="color:#9ca3af;font-size:12px;margin-top:24px">Hechizos de María · hechizosdemaria.com</p>
    </div>
</div>
