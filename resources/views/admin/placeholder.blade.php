@extends('admin.layouts.app')
@section('title', $title)
@section('page_title', $title)

@section('content')
<div class="bg-white border border-pink-200 rounded-xl p-12 text-center max-w-2xl mx-auto">
    <h2 class="font-heading text-2xl text-pink-700 mb-3">{{ $title }}</h2>
    <p class="text-gray-600">Seccion en desarrollo.</p>
</div>
@endsection
