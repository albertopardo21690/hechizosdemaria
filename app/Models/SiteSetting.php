<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("site_setting.{$key}", 3600, function () use ($key, $default) {
            return static::find($key)?->value ?? $default;
        });
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("site_setting.{$key}");
    }

    public static function designTokens(): array
    {
        return [
            'primary_color' => static::get('primary_color', '#ec4899'),
            'secondary_color' => static::get('secondary_color', '#db2777'),
            'accent_color' => static::get('accent_color', '#f9a8d4'),
            'text_color' => static::get('text_color', '#374151'),
            'heading_font' => static::get('heading_font', 'Cinzel'),
            'body_font' => static::get('body_font', 'Lato'),
        ];
    }
}
