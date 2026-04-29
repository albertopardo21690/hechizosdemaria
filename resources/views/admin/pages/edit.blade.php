@extends('admin.layouts.app')
@section('title', 'Editar: '.$page->title)
@section('page_title')
    <div class="flex items-center gap-3">
        <span>{{ $page->title }}</span>
        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $page->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
            <span class="w-1.5 h-1.5 rounded-full {{ $page->status === 'published' ? 'bg-green-500' : 'bg-amber-500' }}"></span>
            {{ $page->status === 'published' ? 'Publicada' : 'Borrador' }}
        </span>
    </div>
@endsection

@section('content')
<div x-data="{ settingsOpen: false }">
    {{-- Top toolbar --}}
    <div class="flex items-center justify-between mb-6 -mt-2">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pages.index') }}" class="text-gray-400 hover:text-pink-500 transition" title="Volver a páginas">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            </a>
            <span class="text-xs text-gray-400 font-mono">/{{ $page->slug }}</span>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('page', $page->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg border border-pink-200 text-pink-600 hover:bg-pink-50 text-xs font-bold uppercase tracking-widest transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Vista previa
            </a>
            <button @click="settingsOpen = true" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg border border-pink-200 text-gray-600 hover:bg-pink-50 text-xs font-bold uppercase tracking-widest transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Configuración
            </button>
        </div>
    </div>

    {{-- Page Builder --}}
    <livewire:admin.page-builder :page="$page" :key="'builder-'.$page->id" />

    {{-- Settings slide-over panel --}}
    <div x-show="settingsOpen" x-cloak class="fixed inset-0 z-50" @keydown.escape.window="settingsOpen = false">
        {{-- Backdrop --}}
        <div x-show="settingsOpen"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-black/30" @click="settingsOpen = false"></div>

        {{-- Panel --}}
        <div x-show="settingsOpen"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
             class="absolute top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl overflow-y-auto">

            <div class="sticky top-0 bg-white z-10 border-b border-pink-100 px-6 py-4 flex items-center justify-between">
                <h2 class="font-heading text-lg text-pink-700">Configuración</h2>
                <button @click="settingsOpen = false" class="p-1.5 rounded-lg hover:bg-pink-50 text-gray-400 hover:text-pink-500 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.pages.update', $page) }}" class="p-6 space-y-6">
                @csrf @method('PUT')

                {{-- General --}}
                <section class="space-y-4">
                    <h3 class="text-xs uppercase tracking-widest text-gray-400 font-bold">General</h3>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Título *</label>
                        <input type="text" name="title" value="{{ old('title', $page->title) }}" required class="w-full border border-pink-200 rounded-xl px-4 py-2.5 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                        @error('title')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Slug</label>
                        <div class="flex items-center gap-1">
                            <span class="text-xs text-gray-400">/</span>
                            <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" required class="flex-1 border border-pink-200 rounded-xl px-4 py-2.5 text-sm font-mono focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                        </div>
                        @error('slug')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Resumen</label>
                        <textarea name="excerpt" rows="2" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">{{ old('excerpt', $page->excerpt) }}</textarea>
                    </div>
                </section>

                {{-- Publicación --}}
                <section class="space-y-4 pt-4 border-t border-pink-100">
                    <h3 class="text-xs uppercase tracking-widest text-gray-400 font-bold">Publicación</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Estado</label>
                            <select name="status" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 text-sm focus:border-pink-400 focus:outline-none bg-white">
                                <option value="published" @selected(old('status', $page->status) === 'published')>Publicada</option>
                                <option value="draft" @selected(old('status', $page->status) === 'draft')>Borrador</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Plantilla</label>
                            <select name="template" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 text-sm focus:border-pink-400 focus:outline-none bg-white">
                                <option value="default" @selected(old('template', $page->template) === 'default')>Estándar</option>
                                <option value="landing" @selected(old('template', $page->template) === 'landing')>Landing</option>
                                <option value="legal" @selected(old('template', $page->template) === 'legal')>Legal</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Orden</label>
                        <input type="number" name="sort" value="{{ old('sort', $page->sort ?? 0) }}" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                    </div>
                </section>

                {{-- SEO --}}
                <section class="space-y-4 pt-4 border-t border-pink-100">
                    <h3 class="text-xs uppercase tracking-widest text-gray-400 font-bold">SEO</h3>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Título SEO</label>
                        <input type="text" name="seo[title]" value="{{ old('seo.title', $page->seo['title'] ?? '') }}" placeholder="{{ $page->title }}" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                        <p class="text-[10px] text-gray-400 mt-1">Dejar vacío para usar el título de la página</p>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Meta descripción</label>
                        <textarea name="seo[description]" rows="2" placeholder="Descripción para Google" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">{{ old('seo.description', $page->seo['description'] ?? '') }}</textarea>
                    </div>
                    <div>
                        @include('admin._partials.media-input', [
                            'name' => 'seo[og_image]',
                            'label' => 'Imagen OG (redes sociales)',
                            'value' => old('seo.og_image', $page->seo['og_image'] ?? ''),
                            'placeholder' => 'Elige o sube una imagen',
                        ])
                    </div>
                </section>

                {{-- Hidden content field --}}
                <input type="hidden" name="content" value="{{ $page->content }}">

                {{-- Actions --}}
                <div class="pt-4 border-t border-pink-100 space-y-3">
                    <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold uppercase tracking-widest text-sm py-3 rounded-xl transition shadow-lg shadow-pink-500/20">
                        Guardar configuración
                    </button>
                </div>
            </form>

            {{-- Danger zone --}}
            <div class="p-6 pt-0">
                <details class="border border-red-200 rounded-xl">
                    <summary class="px-4 py-3 cursor-pointer text-xs font-bold uppercase tracking-widest text-red-500 hover:bg-red-50 rounded-xl">Zona peligrosa</summary>
                    <div class="px-4 pb-4 pt-2">
                        <p class="text-xs text-gray-500 mb-3">Eliminar esta página de forma permanente. Esta acción no se puede deshacer.</p>
                        <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('¿Eliminar «{{ $page->title }}» permanentemente?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full border border-red-300 text-red-600 hover:bg-red-50 font-bold text-xs uppercase tracking-widest py-2.5 rounded-xl transition">Eliminar página</button>
                        </form>
                    </div>
                </details>
            </div>
        </div>
    </div>
</div>
@endsection
