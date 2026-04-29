<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    protected $guarded = [];

    public function url(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function sizeForHumans(): string
    {
        $bytes = $this->size;
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1).' MB';
        }

        return round($bytes / 1024, 1).' KB';
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public static function folders(): array
    {
        return static::distinct()->pluck('folder')->sort()->values()->toArray();
    }
}
