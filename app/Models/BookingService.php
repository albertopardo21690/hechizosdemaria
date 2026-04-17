<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookingService extends Model
{
    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'bool',
        'requires_payment' => 'bool',
        'show_in_catalog' => 'bool',
        'settings' => 'array',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCatalog($query)
    {
        return $query->active()->where('show_in_catalog', true)->orderBy('sort');
    }

    public static function deliveryMethods(): array
    {
        return [
            'whatsapp' => 'WhatsApp',
            'telefono' => 'Teléfono',
            'videollamada' => 'Videollamada',
            'presencial' => 'Presencial',
            'entrega' => 'Entrega de resultado',
        ];
    }

    public static function categories(): array
    {
        return [
            'lectura' => 'Lectura de tarot',
            'ritual' => 'Ritual',
            'limpieza' => 'Limpieza energética',
            'consulta' => 'Consulta general',
            'otro' => 'Otro servicio',
        ];
    }
}
