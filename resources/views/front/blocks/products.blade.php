@php
    $p = $block['props'];
    $items = collect();
    if ($slug = $p['collection_slug'] ?? null) {
        $collection = \Lunar\Models\Collection::whereHas('urls', fn ($q) => $q->where('slug', $slug))->first();
        if ($collection) {
            $items = $collection->products()->where('status', 'published')->with(['variants.prices.currency', 'media', 'urls'])->take((int) ($p['limit'] ?? 4))->get();
        }
    }
@endphp

@if($items->count())
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($p['title'] ?? null)<h2 class="font-heading text-3xl md:text-4xl text-pink-700 text-center mb-10">{{ $p['title'] }}</h2>@endif
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($items as $product)
                @include('front.partials.product-card', ['product' => $product, 'badge' => null])
            @endforeach
        </div>
    </div>
</section>
@endif
