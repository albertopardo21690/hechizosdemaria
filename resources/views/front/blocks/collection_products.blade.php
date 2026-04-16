@php
    if (! isset($products)) return;
    $perRow = (int) ($block['props']['per_row'] ?? 4);
    $limit = (int) ($block['props']['limit'] ?? 24);
    $items = $products instanceof \Illuminate\Contracts\Pagination\Paginator ? $products : (is_iterable($products) ? $products : collect());
    $gridCls = match($perRow) {
        2 => 'grid-cols-1 sm:grid-cols-2',
        3 => 'grid-cols-2 md:grid-cols-3',
        default => 'grid-cols-2 md:grid-cols-3 lg:grid-cols-4',
    };
    $displayed = 0;
@endphp
<div class="grid {{ $gridCls }} gap-6">
    @foreach($items as $p)
        @if($displayed >= $limit) @break @endif
        @php
            $pName = $p->attribute_data['name']?->getValue() ?? '';
            $pSlug = $p->urls->first()?->slug ?? '';
            $pVariant = $p->variants->first();
            $pPrice = $pVariant?->prices->firstWhere('currency.code', 'EUR');
            $pImage = $p->getFirstMedia('images');
            $displayed++;
        @endphp
        <a href="{{ $pSlug ? route('product', $pSlug) : '#' }}" class="group block">
            <div class="aspect-square bg-pink-50 rounded-lg overflow-hidden mb-3">
                @if($pImage)
                    <img src="{{ $pImage->getUrl('medium') }}" alt="{{ $pName }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                @endif
            </div>
            <h3 class="font-heading text-pink-700 text-base leading-tight mb-1">{{ $pName }}</h3>
            @if($pPrice)
                <p class="text-pink-600 font-semibold">{{ number_format($pPrice->price->decimal, 2, ',', '.') }} €</p>
            @endif
        </a>
    @endforeach
</div>
@if($products instanceof \Illuminate\Contracts\Pagination\Paginator)
    <div class="mt-10">{{ $products->links() }}</div>
@endif
