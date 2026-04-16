@php
    $p = $block['props'];
    $style = $p['style'] ?? 'solid';
    $color = $p['color'] ?? 'pink';
    $size = $p['size'] ?? 'md';
    $align = $p['align'] ?? 'left';
    $fullWidth = $p['full_width'] ?? false;
    $target = ($p['target_blank'] ?? false) ? ' target="_blank" rel="noopener"' : '';
    $alignCls = match($align) { 'center' => 'text-center', 'right' => 'text-right', default => 'text-left' };
    $sizeCls = match($size) { 'sm' => 'px-4 py-2 text-xs', 'lg' => 'px-8 py-4 text-base', default => 'px-6 py-3 text-sm' };
    $baseCls = 'inline-flex items-center justify-center font-bold uppercase tracking-widest rounded-md transition';
    if ($fullWidth) $baseCls .= ' w-full';
    $stylesMap = [
        'solid' => [
            'pink' => 'bg-pink-500 hover:bg-pink-600 text-white',
            'black' => 'bg-gray-900 hover:bg-gray-800 text-white',
            'white' => 'bg-white hover:bg-gray-100 text-gray-900',
            'gold' => 'bg-yellow-500 hover:bg-yellow-600 text-white',
        ],
        'outline' => [
            'pink' => 'border-2 border-pink-500 text-pink-600 hover:bg-pink-50',
            'black' => 'border-2 border-gray-900 text-gray-900 hover:bg-gray-100',
            'white' => 'border-2 border-white text-white hover:bg-white/10',
            'gold' => 'border-2 border-yellow-500 text-yellow-600 hover:bg-yellow-50',
        ],
        'ghost' => [
            'pink' => 'text-pink-600 hover:bg-pink-50',
            'black' => 'text-gray-900 hover:bg-gray-100',
            'white' => 'text-white hover:bg-white/10',
            'gold' => 'text-yellow-600 hover:bg-yellow-50',
        ],
    ];
    $colorCls = $stylesMap[$style][$color] ?? $stylesMap['solid']['pink'];
@endphp
<div class="{{ $alignCls }}">
    <a href="{{ \App\Support\DynamicContent::render($p['url'] ?? '#') }}"{!! $target !!} class="{{ $baseCls }} {{ $sizeCls }} {{ $colorCls }}">
        {{ \App\Support\DynamicContent::render($p['text'] ?? '') }}
    </a>
</div>
