@php
    if (! isset($collection)) return;
    $tag = $block['props']['tag'] ?? 'h1';
    $align = $block['props']['align'] ?? 'center';
    $alignCls = match($align) { 'center' => 'text-center', 'right' => 'text-right', default => 'text-left' };
    $tagCls = match($tag) {
        'h1' => 'font-heading text-4xl md:text-5xl text-pink-700',
        'h2' => 'font-heading text-3xl md:text-4xl text-pink-700',
        default => 'font-heading text-2xl text-pink-700',
    };
    $name = $collection->attribute_data['name']?->getValue() ?? '';
@endphp
<{{ $tag }} class="{{ $tagCls }} {{ $alignCls }}">{{ $name }}</{{ $tag }}>
