@php $p = $block['props']; @endphp
<section class="py-10">
    <div class="max-w-4xl mx-auto px-4 text-{{ $p['align'] ?? 'center' }}">
        @if($p['eyebrow'] ?? null)<p class="text-pink-500 text-xs tracking-[0.4em] uppercase mb-2">{{ \App\Support\DynamicContent::render($p['eyebrow']) }}</p>@endif
        <h2 class="font-heading text-3xl md:text-4xl text-pink-700">{{ \App\Support\DynamicContent::render($p['text'] ?? '') }}</h2>
        @if($p['divider'] ?? false)<div class="w-24 h-px bg-pink-400 mx-auto mt-4"></div>@endif
    </div>
</section>
