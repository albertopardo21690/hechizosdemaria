@extends('layouts.app')

@section('title', 'Tienda Magica')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Todo lo que necesitas</p>
        <h1 class="font-heading text-4xl md:text-5xl text-shimmer">Tienda Magica</h1>
    </div>

    <div class="grid lg:grid-cols-[250px_1fr] gap-8">
        <aside class="lg:sticky lg:top-24 h-fit">
            <h3 class="font-heading text-gold-400 uppercase tracking-widest text-sm mb-4">Categorias</h3>
            <ul class="space-y-2 text-sm">
                @foreach($collections as $c)
                    @php
                        $cSlug = $c->urls->where('default', true)->first()?->slug ?? $c->urls->first()?->slug;
                        $cName = $c->attribute_data['name']?->getValue() ?? '-';
                    @endphp
                    @if($cSlug)
                        <li><a href="{{ route('collection', $cSlug) }}" class="text-gray-600 hover:text-gold-400">{{ $cName }}</a></li>
                    @endif
                @endforeach
            </ul>
        </aside>

        <div>
            <p class="text-sm text-gray-500 mb-6">{{ $products->total() }} productos</p>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    @include('front.partials.product-card')
                @endforeach
            </div>
            <div class="mt-10">{{ $products->links() }}</div>
        </div>
    </div>
</section>
@endsection
