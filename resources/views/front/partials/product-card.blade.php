@php
    $name = $product->attribute_data['name']?->getValue() ?? '-';
    $slug = $product->urls->where('default', true)->first()?->slug ?? $product->urls->first()?->slug;
    $variant = $product->variants->first();
    $eurPrice = $variant?->prices->firstWhere('currency.code', 'EUR') ?? $variant?->prices->first();
    $image = $product->getFirstMedia('images');
@endphp

<a href="{{ $slug ? route('product', $slug) : '#' }}" class="group block bg-mystic-800/50 border border-gold-500/10 rounded-xl overflow-hidden hover:border-gold-400/60 transition-all">
    <div class="aspect-square bg-mystic-950 relative overflow-hidden">
        @if($image)
            <img src="{{ $image->getUrl('medium') }}" alt="{{ $name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center text-gold-400/30">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        @endif
    </div>
    <div class="p-4">
        <h3 class="font-heading text-sm mb-2 line-clamp-2 group-hover:text-gold-400 transition">{{ $name }}</h3>
        @if($eurPrice)
            <p class="text-gold-400 font-semibold">{{ number_format($eurPrice->price->decimal, 2, ',', '.') }} €</p>
        @endif
    </div>
</a>
