@extends('layouts.app')

@php
    $colName = $collection->attribute_data['name']?->getValue() ?? 'Coleccion';
    $colDesc = $collection->attribute_data['description']?->getValue() ?? null;
@endphp

@section('title', $colName)

@section('content')
@if(! empty($collectionTemplate) && $collectionTemplate->hasBlocks())
    @foreach($collectionTemplate->sectionsNormalized() as $section)
        @include('front.sections.wrapper', ['section' => $section, 'collection' => $collection, 'products' => $products])
    @endforeach
@else
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Coleccion</p>
        <h1 class="font-heading text-4xl md:text-5xl text-shimmer">{{ $colName }}</h1>
        @if($colDesc)<p class="mt-4 text-gray-600 max-w-2xl mx-auto">{{ $colDesc }}</p>@endif
    </div>

    <p class="text-sm text-gray-500 mb-6">{{ $products->total() }} productos</p>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            @include('front.partials.product-card')
        @empty
            <p class="col-span-full text-center text-gray-500 py-16">No hay productos todavia.</p>
        @endforelse
    </div>
    <div class="mt-10">{{ $products->links() }}</div>
</section>
@endif
@endsection
