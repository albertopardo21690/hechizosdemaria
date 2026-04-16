@extends('layouts.app')

@section('title', $page->title)
@section('meta_description', $page->excerpt ?? $page->title)

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="font-heading text-4xl md:text-5xl text-shimmer mb-8">{{ $page->title }}</h1>
    <div class="prose prose-invert prose-gold max-w-none text-gray-300 [&_a]:text-gold-400 [&_h2]:font-heading [&_h2]:text-gold-300 [&_h3]:font-heading [&_h3]:text-gold-300">
        {!! $page->content !!}
    </div>
</section>
@endsection
