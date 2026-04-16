@php $style = $block['props']['style'] ?? 'line'; @endphp
<div class="py-8 max-w-4xl mx-auto px-4 text-center">
    @if($style === 'line')
        <hr class="border-t border-pink-200">
    @elseif($style === 'dots')
        <div class="flex items-center justify-center gap-3">
            <span class="w-2 h-2 rounded-full bg-pink-400"></span>
            <span class="w-2 h-2 rounded-full bg-pink-400"></span>
            <span class="w-2 h-2 rounded-full bg-pink-400"></span>
        </div>
    @elseif($style === 'star')
        <svg class="w-8 h-8 mx-auto text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.39 7.36H22l-6.18 4.49 2.36 7.36L12 16.72 5.82 21.21l2.36-7.36L2 9.36h7.61z"/></svg>
    @endif
</div>
