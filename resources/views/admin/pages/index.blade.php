@extends('admin.layouts.app')
@section('title', 'Páginas')
@section('page_title', 'Páginas')

@section('content')
<div class="flex items-center justify-between mb-8">
    <p class="text-sm text-gray-500">{{ $pages->total() }} páginas en total</p>
    <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center gap-2 bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs uppercase tracking-widest px-5 py-3 rounded-xl transition shadow-lg shadow-pink-500/20">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Nueva página
    </a>
</div>

{{-- Cards grid --}}
<div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    @forelse($pages as $p)
        @php
            $hasBuilder = $p->hasBlocks();
            $blockCount = $hasBuilder ? count($p->blocks ?? []) : 0;
            $templateLabels = ['default' => 'Estándar', 'landing' => 'Landing', 'legal' => 'Legal'];
            $templateColors = ['default' => 'bg-blue-50 text-blue-600', 'landing' => 'bg-purple-50 text-purple-600', 'legal' => 'bg-gray-100 text-gray-600'];
        @endphp
        <div class="group bg-white border border-pink-100 rounded-2xl overflow-hidden hover:shadow-lg hover:shadow-pink-100/50 transition-all duration-300">
            {{-- Preview area --}}
            <a href="{{ route('admin.pages.edit', $p) }}" class="block relative h-36 bg-gradient-to-br from-pink-50 to-white overflow-hidden">
                @if($hasBuilder)
                    <div class="absolute inset-0 p-4 opacity-60 scale-[0.4] origin-top-left pointer-events-none" style="width: 250%; height: 250%;">
                        {{-- Mini preview blocks --}}
                        @foreach(array_slice($p->blocks ?? [], 0, 4) as $block)
                            <div class="mb-2 bg-pink-100/50 rounded h-6"></div>
                        @endforeach
                    </div>
                @else
                    <div class="flex items-center justify-center h-full text-pink-200">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    </div>
                @endif

                {{-- Status badge --}}
                <span class="absolute top-3 right-3 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $p->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $p->status === 'published' ? 'bg-green-500' : 'bg-amber-500' }}"></span>
                    {{ $p->status === 'published' ? 'Publicada' : 'Borrador' }}
                </span>

                {{-- Template badge --}}
                <span class="absolute top-3 left-3 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $templateColors[$p->template] ?? 'bg-gray-100 text-gray-600' }}">
                    {{ $templateLabels[$p->template] ?? $p->template }}
                </span>

                {{-- Hover overlay --}}
                <div class="absolute inset-0 bg-pink-500/0 group-hover:bg-pink-500/5 transition-colors flex items-center justify-center">
                    <span class="opacity-0 group-hover:opacity-100 transition-opacity bg-white/90 backdrop-blur-sm text-pink-600 font-bold text-xs uppercase tracking-widest px-4 py-2 rounded-lg shadow">
                        Editar
                    </span>
                </div>
            </a>

            {{-- Info --}}
            <div class="p-4">
                <h3 class="font-heading text-sm text-gray-800 truncate mb-1">{{ $p->title }}</h3>
                <p class="text-[10px] text-gray-400 font-mono mb-3 truncate">/{{ $p->slug }}</p>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-[10px] text-gray-400">
                        @if($hasBuilder)
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                                {{ $blockCount }} bloques
                            </span>
                        @else
                            <span>Sin bloques</span>
                        @endif
                    </div>

                    {{-- Quick actions --}}
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('page', $p->slug) }}" target="_blank" title="Ver" class="p-1.5 rounded-lg hover:bg-pink-50 text-gray-400 hover:text-pink-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.pages.duplicate', $p) }}" title="Duplicar" class="inline">
                            @csrf
                            <button type="submit" class="p-1.5 rounded-lg hover:bg-pink-50 text-gray-400 hover:text-pink-500 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75"/></svg>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.pages.destroy', $p) }}" title="Eliminar" class="inline" onsubmit="return confirm('¿Eliminar «{{ $p->title }}»?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-20">
            <div class="mx-auto w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-pink-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            </div>
            <h3 class="font-heading text-lg text-gray-700 mb-2">Sin páginas todavía</h3>
            <p class="text-sm text-gray-500 mb-6">Crea tu primera página para empezar.</p>
            <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center gap-2 bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs uppercase tracking-widest px-5 py-3 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Crear página
            </a>
        </div>
    @endforelse
</div>

@if($pages->hasPages())
    <div class="mt-8">{{ $pages->links() }}</div>
@endif
@endsection
