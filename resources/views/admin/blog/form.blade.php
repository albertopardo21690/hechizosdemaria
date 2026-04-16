@extends('admin.layouts.app')
@section('title', $post ? 'Editar post' : 'Nuevo post')
@section('page_title', $post ? $post->title : 'Nuevo post')

@section('content')
<form method="POST" action="{{ $post ? route('admin.blog.update', $post) : route('admin.blog.store') }}" class="grid lg:grid-cols-[1fr_300px] gap-6">
    @csrf @if($post) @method('PUT') @endif

    <div class="space-y-6">
        <section class="bg-white border border-pink-200 rounded-xl p-6 space-y-4">
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Título *</label>
                <input type="text" name="title" value="{{ old('title', $post?->title) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
            </div>
            <div>
                @include('admin._partials.slug-field', ['source' => 'title', 'slug' => old('slug', $post?->slug ?? ''), 'sourceValue' => old('title', $post?->title ?? ''), 'urlPrefix' => '/blog/'])
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Resumen</label>
                <textarea name="excerpt" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">{{ old('excerpt', $post?->excerpt) }}</textarea>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Contenido</label>
                <textarea name="content" rows="18" data-rich-editor class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">{!! old('content', $post?->content) !!}</textarea>
            </div>
        </section>
    </div>

    <aside class="space-y-4">
        <section class="bg-white border border-pink-200 rounded-xl p-6 space-y-3">
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Estado</label>
                <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                    <option value="published" @selected(old('status', $post?->status) === 'published')>Publicado</option>
                    <option value="draft" @selected(old('status', $post?->status ?? 'draft') === 'draft')>Borrador</option>
                </select>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Categoría</label>
                <select name="category" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                    <option value="">-</option>
                    @foreach(['horoscopo'=>'Horóscopo','tarot'=>'Tarot','rituales'=>'Rituales','espiritualidad'=>'Espiritualidad','noticias'=>'Noticias'] as $k => $v)
                        <option value="{{ $k }}" @selected(old('category', $post?->category) === $k)>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Signo (si aplica)</label>
                <select name="zodiac_sign" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                    <option value="">-</option>
                    @foreach(['aries','tauro','geminis','cancer','leo','virgo','libra','escorpio','sagitario','capricornio','acuario','piscis'] as $s)
                        <option value="{{ $s }}" @selected(old('zodiac_sign', $post?->zodiac_sign) === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Publicado el</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i')) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
            </div>
        </section>

        <button type="submit" class="w-full bg-gradient-to-br from-pink-600 to-pink-500 text-white font-bold uppercase tracking-widest text-sm py-3 rounded-md">{{ $post ? 'Guardar' : 'Crear' }}</button>

        @if($post)
            <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" onsubmit="return confirm('Eliminar post?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full border border-red-300 text-red-600 hover:bg-red-50 text-xs uppercase tracking-widest font-semibold py-2.5 rounded-md">Eliminar</button>
            </form>
        @endif
    </aside>
</form>
@endsection
