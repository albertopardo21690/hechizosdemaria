<?php

namespace App\Support;

use Illuminate\Support\Facades\View;

class DynamicContent
{
    public static function render(?string $text): string
    {
        if ($text === null || $text === '') {
            return '';
        }
        $context = View::shared('themeContext', []);

        return preg_replace_callback('/\{\{\s*([a-z_]+)\.([a-z_]+)\s*\}\}/i', function ($m) use ($context) {
            return self::resolve(strtolower($m[1]), strtolower($m[2]), $context);
        }, $text);
    }

    protected static function resolve(string $scope, string $key, array $context): string
    {
        if ($scope === 'site') {
            return match ($key) {
                'name' => 'Hechizos de María',
                'email' => 'hechizosdemaria@gmail.com',
                'phone' => '+34 695 619 087',
                'year' => (string) now()->year,
                default => '',
            };
        }

        if ($scope === 'product' && isset($context['product'])) {
            $p = $context['product'];
            $variant = $p->variants->first();
            $eur = $variant?->prices->firstWhere('currency.code', 'EUR');

            return match ($key) {
                'name' => (string) ($p->attribute_data['name']?->getValue() ?? ''),
                'slug' => (string) ($p->urls->first()?->slug ?? ''),
                'sku' => (string) ($variant?->sku ?? ''),
                'price' => $eur ? number_format($eur->price->decimal, 2, ',', '.').' €' : '',
                'stock' => (string) ($variant?->stock ?? ''),
                'description' => strip_tags((string) ($p->attribute_data['description']?->getValue() ?? '')),
                default => '',
            };
        }

        if ($scope === 'collection' && isset($context['collection'])) {
            $c = $context['collection'];

            return match ($key) {
                'name' => (string) ($c->attribute_data['name']?->getValue() ?? ''),
                'slug' => (string) ($c->urls->first()?->slug ?? ''),
                'description' => strip_tags((string) ($c->attribute_data['description']?->getValue() ?? '')),
                default => '',
            };
        }

        if ($scope === 'page' && isset($context['page'])) {
            $pg = $context['page'];

            return match ($key) {
                'title' => (string) $pg->title,
                'slug' => (string) $pg->slug,
                'excerpt' => (string) $pg->excerpt,
                default => '',
            };
        }

        return '';
    }
}
