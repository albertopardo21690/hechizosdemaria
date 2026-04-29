@extends('admin.layouts.app')
@section('title', 'Nueva página')
@section('page_title', 'Nueva página')

@section('content')
<div x-data="{ step: 1, template: 'default', title: '', slug: '' }" class="max-w-4xl mx-auto">

    {{-- Progress --}}
    <div class="flex items-center justify-center gap-4 mb-10">
        <div class="flex items-center gap-2">
            <div :class="step >= 1 ? 'bg-pink-500 text-white' : 'bg-pink-100 text-pink-400'" class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition">1</div>
            <span :class="step >= 1 ? 'text-pink-700' : 'text-gray-400'" class="text-xs uppercase tracking-widest font-semibold hidden sm:inline">Tipo</span>
        </div>
        <div class="w-12 h-px" :class="step >= 2 ? 'bg-pink-400' : 'bg-pink-200'"></div>
        <div class="flex items-center gap-2">
            <div :class="step >= 2 ? 'bg-pink-500 text-white' : 'bg-pink-100 text-pink-400'" class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition">2</div>
            <span :class="step >= 2 ? 'text-pink-700' : 'text-gray-400'" class="text-xs uppercase tracking-widest font-semibold hidden sm:inline">Nombre</span>
        </div>
    </div>

    {{-- STEP 1: Elegir plantilla --}}
    <div x-show="step === 1" x-transition>
        <h2 class="font-heading text-2xl text-pink-700 text-center mb-2">¿Qué tipo de página necesitas?</h2>
        <p class="text-sm text-gray-500 text-center mb-8">Elige una plantilla base. Podrás personalizarla completamente con el Page Builder.</p>

        <div class="grid sm:grid-cols-3 gap-5">
            {{-- Default --}}
            <button type="button" @click="template = 'default'"
                    :class="template === 'default' ? 'ring-2 ring-pink-500 border-pink-400' : 'border-pink-100 hover:border-pink-300'"
                    class="group bg-white border-2 rounded-2xl p-6 text-left transition-all">
                <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <h3 class="font-heading text-lg text-gray-800 mb-1">Estándar</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Página con header y footer. Sobre mí, contacto, FAQ...</p>
                <div class="mt-4 flex gap-1">
                    <div class="h-1 flex-1 rounded bg-pink-200"></div>
                    <div class="h-1 flex-1 rounded bg-pink-100"></div>
                    <div class="h-1 flex-1 rounded bg-pink-100"></div>
                </div>
            </button>

            {{-- Landing --}}
            <button type="button" @click="template = 'landing'"
                    :class="template === 'landing' ? 'ring-2 ring-pink-500 border-pink-400' : 'border-pink-100 hover:border-pink-300'"
                    class="group bg-white border-2 rounded-2xl p-6 text-left transition-all">
                <div class="w-14 h-14 rounded-xl bg-purple-50 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6"/></svg>
                </div>
                <h3 class="font-heading text-lg text-gray-800 mb-1">Landing</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Página completa sin header/footer. Promociones, campañas...</p>
                <div class="mt-4 flex gap-1">
                    <div class="h-1 flex-[2] rounded bg-purple-200"></div>
                    <div class="h-1 flex-1 rounded bg-purple-100"></div>
                </div>
            </button>

            {{-- Legal --}}
            <button type="button" @click="template = 'legal'"
                    :class="template === 'legal' ? 'ring-2 ring-pink-500 border-pink-400' : 'border-pink-100 hover:border-pink-300'"
                    class="group bg-white border-2 rounded-2xl p-6 text-left transition-all">
                <div class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18V7.875c0-.621.504-1.125 1.125-1.125H7.5"/></svg>
                </div>
                <h3 class="font-heading text-lg text-gray-800 mb-1">Legal</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Texto legal limpio. Privacidad, aviso legal, condiciones...</p>
                <div class="mt-4 flex gap-1">
                    <div class="h-1 flex-1 rounded bg-gray-200"></div>
                    <div class="h-1 flex-[3] rounded bg-gray-100"></div>
                </div>
            </button>
        </div>

        <div class="text-center mt-8">
            <button type="button" @click="step = 2" class="bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs uppercase tracking-widest px-8 py-3 rounded-xl transition shadow-lg shadow-pink-500/20">
                Continuar
            </button>
        </div>
    </div>

    {{-- STEP 2: Nombre y crear --}}
    <div x-show="step === 2" x-transition x-cloak>
        <h2 class="font-heading text-2xl text-pink-700 text-center mb-2">Dale un nombre</h2>
        <p class="text-sm text-gray-500 text-center mb-8">El slug se genera automáticamente. Podrás cambiarlo después.</p>

        <form method="POST" action="{{ route('admin.pages.store') }}" class="max-w-lg mx-auto">
            @csrf
            <input type="hidden" name="template" :value="template">
            <input type="hidden" name="status" value="draft">
            <input type="hidden" name="sort" value="0">

            <div class="bg-white border border-pink-100 rounded-2xl p-6 space-y-4 shadow-sm">
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Título de la página *</label>
                    <input type="text" name="title" x-model="title" required autofocus
                           @input="slug = title.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
                           placeholder="Ej: Sobre María José"
                           class="w-full border border-pink-200 rounded-xl px-4 py-3 text-lg focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                    @error('title')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">URL</label>
                    <div class="flex items-center gap-1 text-sm text-gray-500">
                        <span class="text-gray-400">{{ url('/') }}/</span>
                        <input type="text" name="slug" x-model="slug" required
                               class="flex-1 border border-pink-200 rounded-lg px-3 py-2 font-mono text-sm focus:border-pink-400 focus:outline-none">
                    </div>
                    @error('slug')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <span class="text-xs text-gray-500">Tipo:</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest"
                          :class="{
                              'bg-blue-50 text-blue-600': template === 'default',
                              'bg-purple-50 text-purple-600': template === 'landing',
                              'bg-gray-100 text-gray-600': template === 'legal'
                          }"
                          x-text="template === 'default' ? 'Estándar' : template === 'landing' ? 'Landing' : 'Legal'"></span>
                    <button type="button" @click="step = 1" class="text-xs text-pink-500 hover:text-pink-700 font-semibold">Cambiar</button>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="button" @click="step = 1" class="text-sm text-gray-500 hover:text-pink-500 font-semibold">← Atrás</button>
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs uppercase tracking-widest px-8 py-3 rounded-xl transition shadow-lg shadow-pink-500/20">
                    Crear e ir al editor
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
