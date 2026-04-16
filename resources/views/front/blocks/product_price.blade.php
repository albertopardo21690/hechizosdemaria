@php
    if (! isset($product)) return;
    $variant = $product->variants->first();
    $eur = $variant?->prices->firstWhere('currency.code', 'EUR');
    $size = $block['props']['size'] ?? 'lg';
    $align = $block['props']['align'] ?? 'left';
    $alignCls = match($align) { 'center' => 'text-center', 'right' => 'text-right', default => 'text-left' };
    $sizeCls = match($size) {
        'sm' => 'text-lg',
        'md' => 'text-2xl',
        'xl' => 'text-5xl',
        default => 'text-3xl md:text-4xl',
    };
@endphp
@if($eur)
    <p class="font-heading {{ $sizeCls }} {{ $alignCls }} text-pink-600">
        {{ number_format($eur->price->decimal, 2, ',', '.') }} €
    </p>
@endif
