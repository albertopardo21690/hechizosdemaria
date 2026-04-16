@php
    $p = $block['props'];
    $icon = $p['icon'] ?? 'sparkle';
    $emoji = match($icon) {
        'star' => '⭐', 'heart' => '❤', 'moon' => '🌙', 'sun' => '☀', 'flame' => '🔥',
        'eye' => '👁', 'hand' => '✋', 'lock' => '🔒', 'check' => '✓', default => '✨',
    };
    $align = $p['align'] ?? 'center';
    $alignCls = match($align) { 'left' => 'text-left items-start', 'right' => 'text-right items-end', default => 'text-center items-center' };
    $url = $p['url'] ?? '';
    $tag = $url ? 'a' : 'div';
    $hrefAttr = $url ? ' href="'.e(\App\Support\DynamicContent::render($url)).'"' : '';
@endphp
<<?= $tag ?>{!! $hrefAttr !!} class="flex flex-col {{ $alignCls }} gap-3 p-6 bg-white border border-pink-100 rounded-xl hover:border-pink-300 hover:shadow-md transition {{ $url ? 'cursor-pointer' : '' }}">
    <div class="text-5xl text-pink-500">{{ $emoji }}</div>
    <h3 class="font-heading text-xl text-pink-700">{{ \App\Support\DynamicContent::render($p['title'] ?? '') }}</h3>
    @if($p['body'] ?? null)
        <p class="text-sm text-gray-600 leading-relaxed max-w-sm">{{ \App\Support\DynamicContent::render($p['body']) }}</p>
    @endif
</<?= $tag ?>>
