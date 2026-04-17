<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'min_cart' => 'decimal:2',
        'is_active' => 'bool',
        'expires_at' => 'datetime',
    ];

    public function isValid(float $cartTotal = 0): bool
    {
        if (! $this->is_active) {
            return false;
        }
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }
        if ($this->uses_limit && $this->used_count >= $this->uses_limit) {
            return false;
        }
        if ($this->min_cart && $cartTotal < (float) $this->min_cart) {
            return false;
        }

        return true;
    }

    public function discount(float $cartTotal): float
    {
        if ($this->type === 'percent') {
            return round($cartTotal * ((float) $this->amount / 100), 2);
        }

        return min((float) $this->amount, $cartTotal);
    }

    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }

    public static function findByCode(string $code): ?self
    {
        return static::where('code', strtolower(trim($code)))->first();
    }
}
