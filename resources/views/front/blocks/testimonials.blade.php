@php
    $p = $block['props'];
    $query = \App\Models\Testimonial::query();
    if ($p['only_featured'] ?? false) {
        $query->where('approved', true)->where('featured', true);
    } else if (!empty($p['ids'])) {
        $query->whereIn('id', $p['ids']);
    } else {
        $query->where('approved', true);
    }
    $items = $query->orderBy('sort')->take(9)->get();
@endphp

@if($items->count())
<section class="py-16 bg-pink-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($p['title'] ?? null)<h2 class="font-heading text-3xl md:text-4xl text-pink-700 text-center mb-10">{{ $p['title'] }}</h2>@endif
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($items as $t)
                <div class="bg-white border border-pink-200 rounded-2xl p-6 shadow-sm">
                    <div class="text-pink-500 mb-3 text-lg">{!! str_repeat('&#9733;', $t->rating) !!}</div>
                    <p class="text-gray-700 italic mb-4 leading-relaxed">"{{ $t->text }}"</p>
                    <div class="text-sm">
                        <div class="font-semibold text-pink-700">{{ $t->name }}</div>
                        @if($t->location)<div class="text-gray-500 text-xs uppercase tracking-widest mt-1">{{ $t->location }}</div>@endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
