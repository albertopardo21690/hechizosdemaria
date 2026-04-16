@extends('admin.layouts.app')
@section('title', $page ? 'Editar página' : 'Nueva página')
@section('page_title', $page ? $page->title : 'Nueva página')

@section('content')
<form method="POST" action="{{ $page ? route('admin.pages.update', $page) : route('admin.pages.store') }}" class="grid lg:grid-cols-[1fr_300px] gap-6">
    @csrf @if($page) @method('PUT') @endif

    <div class="space-y-6">
        <section class="bg-white border border-pink-200 rounded-xl p-6 space-y-4">
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
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Resumen</label>
                <textarea name="excerpt" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">{{ old('excerpt', $page?->excerpt) }}</textarea>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Contenido</label>
                <textarea name="content" rows="20" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-sm focus:border-pink-500 focus:outline-none">{{ old('content', $page?->content) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">HTML permitido.</p>
            </div>
        </section>
    </div>

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

        <button type="submit" class="w-full bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 hover:to-pink-400 text-white font-bold uppercase tracking-widest text-sm py-3 rounded-md">{{ $page ? 'Guardar' : 'Crear' }}</button>

        @if($page)
            <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Eliminar página?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full border border-red-300 text-red-600 hover:bg-red-50 text-xs uppercase tracking-widest font-semibold py-2.5 rounded-md">Eliminar</button>
            </form>
        @endif
    </aside>
</form>
@endsection
