@php $p = $block['props']; $maxW = match($p['width'] ?? 'wide') { 'narrow' => 'max-w-2xl', 'wide' => 'max-w-5xl', 'full' => '', default => 'max-w-5xl' }; @endphp
<section class="py-8">
    <figure class="{{ $maxW }} mx-auto px-4">
        @if($p['src'] ?? null)
            <img src="{{ $p['src'] }}" alt="{{ $p['alt'] ?? '' }}" class="w-full rounded-xl border border-pink-200 shadow">
        @endif
        @if($p['caption'] ?? null)<figcaption class="text-center text-xs text-gray-500 mt-3 italic">{{ $p['caption'] }}</figcaption>@endif
    </figure>
</section>
