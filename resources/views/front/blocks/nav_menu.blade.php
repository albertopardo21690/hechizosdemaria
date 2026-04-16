@php
    $items = $block['props']['items'] ?? [];
    $align = $block['props']['align'] ?? 'right';
    $alignCls = match($align) { 'center' => 'justify-center', 'left' => 'justify-start', default => 'justify-end' };
@endphp
<nav class="flex items-center gap-8 text-sm font-semibold tracking-wider uppercase text-gray-700 {{ $alignCls }}">
    @foreach($items as $it)
        <a href="{{ $it['url'] ?? '#' }}" class="hover:text-pink-500 transition whitespace-nowrap">{{ $it['label'] ?? '' }}</a>
    @endforeach
</nav>
