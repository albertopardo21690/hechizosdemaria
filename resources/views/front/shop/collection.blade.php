@extends('layouts.app')

@php
    $colName = $collection->attribute_data['name']?->getValue() ?? 'Colección';
    $colDesc = $collection->attribute_data['description']?->getValue() ?? null;
    $colSlug = $collection->urls?->where('default', true)->first()?->slug ?? $collection->urls?->first()?->slug;
@endphp

@section('title', $colName)

@section('content')
@if(! empty($collectionTemplate) && $collectionTemplate->hasBlocks())
    @foreach($collectionTemplate->sectionsNormalized() as $section)
        @include('front.sections.wrapper', ['section' => $section, 'collection' => $collection, 'products' => $products])
    @endforeach
@else
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Breadcrumbs --}}
    <nav class="flex items-center gap-2 text-xs text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-pink-500 transition">Inicio</a>
        <span>/</span>
        <a href="{{ route('shop') }}" class="hover:text-pink-500 transition">Tienda</a>
        <span>/</span>
        <span class="text-gray-600">{{ $colName }}</span>
    </nav>

    <div class="text-center mb-12">
        <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-2">Colección</p>
        <h1 class="font-heading text-4xl md:text-5xl text-pink-700">{{ $colName }}</h1>
        @if($colDesc)<p class="mt-4 text-gray-600 max-w-2xl mx-auto leading-relaxed">{!! $colDesc !!}</p>@endif
    </div>

    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500"><span class="font-semibold text-gray-700">{{ $products->total() }}</span> productos</p>
        <a href="{{ route('shop') }}" class="text-pink-500 hover:text-pink-700 text-xs uppercase tracking-widest font-bold">← Toda la tienda</a>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            @include('front.partials.product-card')
        @empty
            <div class="col-span-full text-center py-16">
                <div class="mx-auto w-16 h-16 rounded-full bg-pink-50 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-pink-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                    </svg>
                </div>
                <p class="text-gray-500">No hay productos en esta colección todavía.</p>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="mt-10">{{ $products->links() }}</div>
    @endif
</section>
@endif
@endsection
