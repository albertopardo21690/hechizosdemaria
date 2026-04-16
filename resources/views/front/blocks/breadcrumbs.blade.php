@php
    $sep = $block['props']['separator'] ?? '/';
    $crumbs = [['label' => 'Inicio', 'url' => route('home')]];
    if (isset($product)) {
        $crumbs[] = ['label' => 'Tienda', 'url' => route('shop')];
        $crumbs[] = ['label' => $product->attribute_data['name']?->getValue() ?? '', 'url' => null];
    } elseif (isset($collection)) {
        $crumbs[] = ['label' => 'Tienda', 'url' => route('shop')];
        $crumbs[] = ['label' => $collection->attribute_data['name']?->getValue() ?? '', 'url' => null];
    }
@endphp
<nav class="text-xs text-gray-500 flex items-center gap-2">
    @foreach($crumbs as $i => $c)
        @if($i > 0)<span class="text-gray-300">{{ $sep }}</span>@endif
        @if($c['url'])
            <a href="{{ $c['url'] }}" class="hover:text-pink-600">{{ $c['label'] }}</a>
        @else
            <span class="text-gray-700">{{ $c['label'] }}</span>
        @endif
    @endforeach
</nav>
