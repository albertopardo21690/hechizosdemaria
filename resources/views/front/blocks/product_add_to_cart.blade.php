@php
    if (! isset($product)) return;
    $variant = $product->variants->first();
@endphp
@if($variant)
    <livewire:add-to-cart :variantId="$variant->id" :key="'atc-'.$variant->id.'-'.$block['id']" />
@endif
