@php
    $name = $product->attribute_data['name']?->getValue() ?? '-';
    $slug = $product->urls->where('default', true)->first()?->slug ?? $product->urls->first()?->slug;
    $variant = $product->variants->first();
    $eurPrice = $variant?->prices->firstWhere('currency.code', 'EUR') ?? $variant?->prices->first();
    $image = $product->getFirstMedia('images');
    $badge = $badge ?? null;
@endphp

<a href="{{ $slug ? route('product', $slug) : '#' }}"
   class="group block bg-mystic-800/50 border border-gold-500/10 rounded-xl overflow-hidden hover:border-gold-400/60 transition-all duration-500 hover:-translate-y-2">
    <div class="relative aspect-[4/5] bg-mystic-950 overflow-hidden">
        @if($image)
            <img src="{{ $image->getUrl('medium') }}" alt="{{ $name }}" loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        @else
            <div class="w-full h-full flex items-center justify-center text-gold-400/30">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        @endif

        @if($badge)
            <span class="absolute top-3 left-3 bg-gold-400 text-mystic-900 text-[10px] font-black uppercase px-2 py-1 tracking-widest rounded-sm">{{ $badge }}</span>
        @endif
    </div>

    <div class="p-5">
        <div class="flex gap-0.5 text-gold-400 text-xs mb-2">
            &#9733;&#9733;&#9733;&#9733;&#9733;
        </div>
        <h3 class="font-heading text-base mb-3 line-clamp-2 group-hover:text-gold-400 transition-colors min-h-[2.8rem]">{{ $name }}</h3>
        @if($eurPrice)
            <p class="text-gold-400 font-bold text-lg">{{ number_format($eurPrice->price->decimal, 2, ',', '.') }} €</p>
        @endif
    </div>
</a>
