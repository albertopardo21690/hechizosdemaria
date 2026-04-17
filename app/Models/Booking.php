<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'preferred_date' => 'date',
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'meta' => 'array',
    ];

    public const STATUSES = [
        'pending' => 'Pendiente',
        'accepted' => 'Aceptada',
        'rejected' => 'Rechazada',
        'completed' => 'Completada',
        'cancelled' => 'Cancelada',
        'no_show' => 'No show',
    ];

    public const PAYMENT_STATUSES = [
        'pending' => 'Pendiente',
        'paid' => 'Pagado',
        'refunded' => 'Reembolsado',
        'free' => 'Gratis',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $booking) {
            if (! $booking->reference) {
                $booking->reference = 'HDM-'.strtoupper(Str::random(8));
            }
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(BookingService::class, 'booking_service_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function accept(?string $notes = null): void
    {
        $this->update([
            'status' => 'accepted',
            'accepted_at' => now(),
            'admin_notes' => $notes ?: $this->admin_notes,
        ]);
    }

    public function reject(?string $notes = null): void
    {
        $this->update([
            'status' => 'rejected',
            'admin_notes' => $notes ?: $this->admin_notes,
        ]);
    }

    public function complete(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function cancel(): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }

    public function finalPrice(): float
    {
        return max(0, (float) $this->price - (float) $this->discount);
    }

    public function whatsappUrl(): string
    {
        $msg = "Hola, soy *{$this->customer_name}*.\n"
             ."He reservado: *{$this->service?->name}*.\n"
             ."Referencia: *#{$this->reference}*.\n"
             ."Fecha preferida: *".($this->preferred_date?->format('d/m/Y') ?? 'Flexible')."*.\n"
             .($this->customer_notes ? "Nota: {$this->customer_notes}\n" : '');

        return 'https://api.whatsapp.com/send?phone=34695619087&text='.rawurlencode($msg);
    }
}
