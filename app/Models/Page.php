<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];

    protected $casts = [
        'seo' => 'array',
        'blocks' => 'array',
    ];

    public function hasBlocks(): bool
    {
        return is_array($this->blocks) && count($this->blocks) > 0;
    }
}
