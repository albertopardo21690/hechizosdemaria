@php $p = $block['props']; $count = count($p['items'] ?? []); $cols = min(4, max(1, $count)); @endphp
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-{{ $cols }} gap-6">
            @foreach($p['items'] ?? [] as $item)
                <div class="bg-white border border-pink-200 rounded-xl p-6 text-center">
                    <h3 class="font-heading text-lg text-pink-700 mb-3">{{ $item['title'] ?? '' }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $item['body'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
