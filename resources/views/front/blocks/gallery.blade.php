@php $p = $block['props']; $cols = $p['columns'] ?? 3; @endphp
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-{{ $cols }} gap-4">
            @foreach($p['images'] ?? [] as $img)
                @if($img['src'] ?? null)
                    <div class="aspect-square rounded-xl overflow-hidden border border-pink-200">
                        <img src="{{ $img['src'] }}" alt="{{ $img['alt'] ?? '' }}" class="w-full h-full object-cover hover:scale-105 transition-transform">
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
