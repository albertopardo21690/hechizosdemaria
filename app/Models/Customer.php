<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $guarded = [];

    protected $hidden = ['password', 'remember_token'];

    public function orders()
    {
        return \Lunar\Models\Order::where('meta->customer_email', $this->email)
            ->orderByDesc('placed_at');
    }
}
