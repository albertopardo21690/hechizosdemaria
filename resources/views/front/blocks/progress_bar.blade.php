@php
    $p = $block['props'];
    $percent = max(0, min(100, (int) ($p['percent'] ?? 0)));
    $color = $p['color'] ?? 'pink';
    $colorCls = match($color) { 'black' => 'bg-gray-900', 'gold' => 'bg-yellow-500', default => 'bg-pink-500' };
    $showPercent = $p['show_percent'] ?? true;
@endphp
<div class="w-full space-y-2">
    <div class="flex justify-between items-center text-sm">
        <span class="font-semibold text-gray-700">{{ \App\Support\DynamicContent::render($p['label'] ?? '') }}</span>
        @if($showPercent)<span class="text-pink-600 font-bold">{{ $percent }}%</span>@endif
    </div>
    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
        <div class="hdm-progress-bar h-full {{ $colorCls }} rounded-full transition-all duration-1000" style="width:0" data-target="{{ $percent }}"></div>
    </div>
</div>
