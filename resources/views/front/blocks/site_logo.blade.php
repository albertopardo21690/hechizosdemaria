@php
    $maxH = (int) ($block['props']['max_height'] ?? 64);
    $align = $block['props']['align'] ?? 'left';
    $linkHome = $block['props']['link_home'] ?? true;
    $alignCls = match($align) { 'center' => 'justify-center', 'right' => 'justify-end', default => 'justify-start' };
@endphp
<div class="flex items-center {{ $alignCls }}">
    @if($linkHome)
        <a href="{{ route('home') }}" class="inline-flex items-center">
            <img src="/images/branding/Logo-Hechizos-de-Maria.png" alt="Hechizos de Maria" style="max-height: {{ $maxH }}px; width:auto" class="w-auto">
        </a>
    @else
        <img src="/images/branding/Logo-Hechizos-de-Maria.png" alt="Hechizos de Maria" style="max-height: {{ $maxH }}px; width:auto" class="w-auto">
    @endif
</div>
