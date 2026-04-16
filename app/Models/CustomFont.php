<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomFont extends Model
{
    protected $guarded = [];

    public function url(): string
    {
        return asset('storage/'.ltrim($this->file_path, '/'));
    }
}
