@php
    if (! isset($product)) return;
    $media = $product->getMedia('images');
    $layout = $block['props']['layout'] ?? 'stacked';
@endphp
@if($media->count())
    @if($layout === 'grid')
        <div class="grid grid-cols-2 gap-3">
            @foreach($media as $img)
                <img src="{{ $img->getUrl('large') }}" alt="" class="w-full rounded-lg">
            @endforeach
        </div>
    @elseif($layout === 'carousel')
        <div class="flex gap-3 overflow-x-auto snap-x snap-mandatory">
            @foreach($media as $img)
                <img src="{{ $img->getUrl('large') }}" alt="" class="w-full shrink-0 snap-center rounded-lg">
            @endforeach
        </div>
    @else
        <div class="space-y-3">
            @foreach($media as $img)
                <img src="{{ $img->getUrl('large') }}" alt="" class="w-full rounded-lg">
            @endforeach
        </div>
    @endif
@endif
