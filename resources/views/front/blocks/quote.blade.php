@php $p = $block['props']; @endphp
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-pink-100 via-white to-pink-50"></div>
    <div class="relative max-w-4xl mx-auto px-6 text-center">
        <svg class="w-10 h-10 mx-auto text-pink-400/70 mb-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8v6H5v-6h4m1-4H4a1 1 0 00-1 1v10a1 1 0 001 1h5v4l4-4h1a1 1 0 001-1V5a1 1 0 00-1-1h-5zm11 0h-6a1 1 0 00-1 1v14l4-4h3a1 1 0 001-1V5a1 1 0 00-1-1z"/></svg>
        <blockquote class="font-heading text-2xl md:text-4xl italic text-pink-700 leading-tight">{{ $p['text'] ?? '' }}</blockquote>
        @if($p['author'] ?? null)<p class="mt-6 text-pink-500 text-sm tracking-[0.3em] uppercase">— {{ $p['author'] }}</p>@endif
    </div>
</section>
