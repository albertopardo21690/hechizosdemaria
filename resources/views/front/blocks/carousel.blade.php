@php
    $p = $block['props'] ?? [];
    $slides = $p['slides'] ?? [];
    $autoplay = $p['autoplay'] ?? true;
    $interval = (int) ($p['interval'] ?? 5);
    $arrows = $p['arrows'] ?? true;
    $dots = $p['dots'] ?? true;
    $height = $p['height'] ?? 'md';
    $heightCls = match($height) {
        'sm' => 'h-[300px]',
        'lg' => 'h-[700px]',
        'full' => 'h-screen',
        default => 'h-[500px]',
    };
    $uid = 'car-'.substr($block['id'] ?? uniqid(), 0, 8);
@endphp
@if(count($slides))
<div class="hdm-carousel relative w-full overflow-hidden {{ $heightCls }}"
     data-autoplay="{{ $autoplay ? 'true' : 'false' }}"
     data-interval="{{ $interval * 1000 }}"
     id="{{ $uid }}">
    <div class="hdm-carousel-track relative w-full h-full">
        @foreach($slides as $i => $s)
            <div class="hdm-carousel-slide absolute inset-0 transition-opacity duration-700 {{ $i === 0 ? 'opacity-100' : 'opacity-0 pointer-events-none' }}"
                 data-index="{{ $i }}"
                 @if($s['image'] ?? null) style="background: url('{{ $s['image'] }}') center/cover no-repeat;" @endif>
                <div class="absolute inset-0 bg-black/30"></div>
                <div class="relative h-full flex items-center justify-center text-center text-white px-4">
                    <div class="max-w-3xl">
                        @if($s['heading'] ?? null)<h2 class="font-heading text-3xl md:text-5xl mb-3">{{ \App\Support\DynamicContent::render($s['heading']) }}</h2>@endif
                        @if($s['subheading'] ?? null)<p class="text-lg md:text-xl mb-6 opacity-95">{{ \App\Support\DynamicContent::render($s['subheading']) }}</p>@endif
                        @if($s['cta_text'] ?? null)
                            <a href="{{ $s['cta_url'] ?? '#' }}" class="inline-flex items-center bg-pink-500 hover:bg-pink-600 text-white font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-md transition">{{ $s['cta_text'] }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($arrows && count($slides) > 1)
        <button type="button" class="hdm-carousel-prev absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/80 hover:bg-white text-pink-700 flex items-center justify-center z-10" aria-label="Anterior">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button type="button" class="hdm-carousel-next absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/80 hover:bg-white text-pink-700 flex items-center justify-center z-10" aria-label="Siguiente">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </button>
    @endif

    @if($dots && count($slides) > 1)
        <div class="hdm-carousel-dots absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            @foreach($slides as $i => $s)
                <button type="button" data-index="{{ $i }}" class="w-2.5 h-2.5 rounded-full transition {{ $i === 0 ? 'bg-white' : 'bg-white/50 hover:bg-white/80' }}" aria-label="Slide {{ $i + 1 }}"></button>
            @endforeach
        </div>
    @endif
</div>
@endif
