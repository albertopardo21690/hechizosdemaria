@php $p = $block['props']; $align = $p['align'] ?? 'left'; $hasImg = !empty($p['image']); @endphp
<section class="relative py-20 lg:py-28 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-pink-50 via-white to-pink-100"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid @if($hasImg) lg:grid-cols-2 @endif gap-12 items-center">
            <div class="space-y-5 {{ $align === 'center' ? 'text-center mx-auto max-w-2xl' : '' }}">
                @if($p['eyebrow'] ?? null)<span class="text-pink-500 text-xs tracking-[0.3em] uppercase block">{{ \App\Support\DynamicContent::render($p['eyebrow']) }}</span>@endif
                <h1 class="font-heading text-4xl md:text-6xl text-pink-700 leading-tight">{{ \App\Support\DynamicContent::render($p['heading'] ?? '') }}</h1>
                @if($p['subheading'] ?? null)<p class="font-heading text-lg md:text-xl italic text-pink-600">{{ \App\Support\DynamicContent::render($p['subheading']) }}</p>@endif
                @if($p['body'] ?? null)<p class="text-gray-700 leading-relaxed max-w-lg {{ $align === 'center' ? 'mx-auto' : '' }}">{{ \App\Support\DynamicContent::render($p['body']) }}</p>@endif
                @if($p['cta_text'] ?? null)<div class="pt-3"><a href="{{ \App\Support\DynamicContent::render($p['cta_url'] ?? '#') }}" class="btn-mystic">{{ \App\Support\DynamicContent::render($p['cta_text']) }}</a></div>@endif
            </div>
            @if($hasImg)
                <div class="relative">
                    <div class="absolute inset-0 bg-pink-300/20 blur-3xl rounded-full"></div>
                    <div class="relative aspect-[4/5] max-w-md @if($align !== 'center') ml-auto @else mx-auto @endif rounded-2xl overflow-hidden border border-pink-200 shadow-xl">
                        <img src="{{ $p['image'] }}" alt="{{ $p['heading'] ?? '' }}" class="w-full h-full object-cover">
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
