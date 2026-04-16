@extends('admin.layouts.app')
@section('title', $page ? 'Editar página' : 'Nueva página')
@section('page_title', $page ? $page->title : 'Nueva página')

@section('content')

{{-- META FORM --}}
<form method="POST" action="{{ $page ? route('admin.pages.update', $page) : route('admin.pages.store') }}" class="grid lg:grid-cols-[1fr_300px] gap-6 mb-8">
    @csrf @if($page) @method('PUT') @endif

    <section class="bg-white border border-pink-200 rounded-xl p-6 space-y-4">
        <h2 class="font-heading text-lg text-pink-700 mb-3">Configuración de la página</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Título *</label>
                <input type="text" name="title" value="{{ old('title', $page?->title) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                @error('title')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Slug *</label>
                <input type="text" name="slug" value="{{ old('slug', $page?->slug) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none font-mono text-sm">
                @error('slug')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Resumen</label>
                <textarea name="excerpt" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">{{ old('excerpt', $page?->excerpt) }}</textarea>
            </div>
        </div>
        {{-- Content legacy HTML (fallback) --}}
        <input type="hidden" name="content" value="{{ old('content', $page?->content) }}">
    </section>

    <aside class="space-y-4">
        <section class="bg-white border border-pink-200 rounded-xl p-6 space-y-3">
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Estado</label>
                <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                    <option value="published" @selected(old('status', $page?->status) === 'published')>Publicada</option>
                    <option value="draft" @selected(old('status', $page?->status ?? 'draft') === 'draft')>Borrador</option>
                </select>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Plantilla</label>
                <select name="template" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                    <option value="default" @selected(old('template', $page?->template ?? 'default') === 'default')>Default</option>
                    <option value="landing" @selected(old('template', $page?->template) === 'landing')>Landing</option>
                    <option value="legal" @selected(old('template', $page?->template) === 'legal')>Legal</option>
                </select>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Orden</label>
                <input type="number" name="sort" value="{{ old('sort', $page?->sort ?? 0) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
            </div>
        </section>

        <button type="submit" class="w-full bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 hover:to-pink-400 text-white font-bold uppercase tracking-widest text-sm py-3 rounded-md">{{ $page ? 'Guardar configuración' : 'Crear página' }}</button>
    </aside>
</form>

{{-- PAGE BUILDER (solo en edición) --}}
@if($page)
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="font-heading text-2xl text-pink-700">Contenido · Page Builder</h2>
            <p class="text-xs text-gray-500">Los bloques se guardan automáticamente al editarlos.</p>
        </div>
        <a href="{{ route('page', $page->slug) }}" target="_blank" class="text-pink-600 hover:text-pink-700 text-xs uppercase tracking-widest font-semibold inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            Ver página pública
        </a>
    </div>

    <livewire:admin.page-builder :page="$page" :key="'builder-'.$page->id" />

    <details class="mt-10 bg-white border border-pink-200 rounded-xl">
        <summary class="px-6 py-3 cursor-pointer text-sm font-semibold text-gray-700 hover:bg-pink-50/50">Contenido HTML legacy (avanzado, fallback si no hay bloques)</summary>
        <form method="POST" action="{{ route('admin.pages.update', $page) }}" class="p-6 pt-0 space-y-3">
            @csrf @method('PUT')
            <input type="hidden" name="title" value="{{ $page->title }}">
            <input type="hidden" name="slug" value="{{ $page->slug }}">
            <input type="hidden" name="status" value="{{ $page->status }}">
            <input type="hidden" name="template" value="{{ $page->template }}">
            <textarea name="content" rows="12" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs">{{ $page->content }}</textarea>
            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs uppercase tracking-widest font-semibold px-5 py-2 rounded-md">Guardar HTML legacy</button>
        </form>
    </details>

    <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="mt-6 text-right" onsubmit="return confirm('Eliminar esta página permanentemente?')">
        @csrf @method('DELETE')
        <button type="submit" class="border border-red-300 text-red-600 hover:bg-red-50 text-xs uppercase tracking-widest font-semibold px-6 py-2.5 rounded-md">Eliminar página</button>
    </form>
@endif

@endsection
