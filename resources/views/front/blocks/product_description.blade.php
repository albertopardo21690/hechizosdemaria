@php
    if (! isset($product)) return;
    $desc = $product->attribute_data['description']?->getValue() ?? '';
@endphp
@if($desc)
    <div class="prose prose-pink max-w-none text-gray-700 [&_a]:text-pink-600 [&_h2]:font-heading [&_h2]:text-pink-700 [&_h3]:font-heading [&_h3]:text-pink-700">
        {!! $desc !!}
    </div>
@endif
