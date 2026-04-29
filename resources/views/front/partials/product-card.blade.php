@php
    $name = $product->attribute_data['name']?->getValue() ?? '-';
    $slug = $product->urls->where('default', true)->first()?->slug ?? $product->urls->first()?->slug;
    $variant = $product->variants->first();
    $eurPrice = $variant?->prices->firstWhere('currency.code', 'EUR') ?? $variant?->prices->first();
    $image = $product->getFirstMedia('images');
    $badge = $badge ?? null;
    $collection = $product->collections->first();
    $collectionName = $collection?->attribute_data['name']?->getValue();
@endphp

<div class="group relative bg-white rounded-2xl border border-pink-100 overflow-hidden transition-all duration-500 hover:shadow-xl hover:shadow-pink-200/40 hover:-translate-y-1">
    {{-- Image --}}
    <a href="{{ $slug ? route('product', $slug) : '#' }}" class="block relative aspect-[3/4] overflow-hidden bg-gradient-to-br from-pink-50 to-white">
        @if($image)
            <img src="{{ $image->getUrl('medium') }}" alt="{{ $name }}" loading="lazy"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
        @else
            <div class="w-full h-full flex flex-col items-center justify-center text-pink-300">
                <svg class="w-16 h-16 mb-2 opacity-60" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/>
                </svg>
                <span class="text-[10px] uppercase tracking-[0.3em] font-heading text-pink-400">Hechizos de María</span>
            </div>
        @endif

        {{-- Badge --}}
        @if($badge)
            <span class="absolute top-3 left-3 bg-pink-500 text-white text-[10px] font-bold uppercase px-2.5 py-1 tracking-widest rounded-full shadow-md">{{ $badge }}</span>
        @endif

        {{-- Quick add overlay --}}
        @if($variant)
            <div class="absolute inset-x-0 bottom-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                <button onclick="event.preventDefault(); Livewire.dispatch('quick-add', { variantId: {{ $variant->id }} })"
                        class="w-full bg-pink-500 hover:bg-pink-600 text-white text-xs font-bold uppercase tracking-widest py-2.5 rounded-lg shadow-lg backdrop-blur-sm transition-colors">
                    Añadir al carrito
                </button>
            </div>
        @endif
    </a>

    {{-- Info --}}
    <a href="{{ $slug ? route('product', $slug) : '#' }}" class="block p-4">
        @if($collectionName)
            <span class="text-[10px] uppercase tracking-[0.25em] text-pink-400 font-semibold">{{ $collectionName }}</span>
        @endif
        <h3 class="font-heading text-sm text-gray-800 mt-1 mb-2 line-clamp-2 group-hover:text-pink-600 transition-colors min-h-[2.5rem] leading-snug">{{ $name }}</h3>
        @if($eurPrice)
            <p class="text-pink-600 font-bold text-lg">{{ number_format($eurPrice->price->decimal, 2, ',', '.') }} €</p>
        @endif
    </a>
</div>
