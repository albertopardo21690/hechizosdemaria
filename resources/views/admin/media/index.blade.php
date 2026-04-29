@extends('admin.layouts.app')
@section('title', 'Archivos')
@section('page_title', 'Gestor de archivos')

@section('content')
<div x-data="mediaManager()" class="space-y-6">

    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            {{-- Search --}}
            <form method="GET" class="relative">
                <input type="text" name="q" value="{{ $search }}" placeholder="Buscar archivos..."
                       class="border border-pink-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100 w-64">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-pink-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                @if($folder)<input type="hidden" name="folder" value="{{ $folder }}">@endif
            </form>

            {{-- Folder filter --}}
            @if(count($folders))
                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.media.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ !$folder ? 'bg-pink-100 text-pink-700' : 'text-gray-500 hover:bg-pink-50' }} transition">Todos</a>
                    @foreach($folders as $f)
                        <a href="{{ route('admin.media.index', ['folder' => $f]) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $folder === $f ? 'bg-pink-100 text-pink-700' : 'text-gray-500 hover:bg-pink-50' }} transition">{{ $f }}</a>
                    @endforeach
                </div>
            @endif
        </div>

        <button @click="showUpload = true" class="inline-flex items-center gap-2 bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs uppercase tracking-widest px-5 py-3 rounded-xl transition shadow-lg shadow-pink-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
            Subir archivos
        </button>
    </div>

    {{-- Upload modal --}}
    <div x-show="showUpload" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" @keydown.escape.window="showUpload = false">
        <div class="absolute inset-0 bg-black/30" @click="showUpload = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6" @click.stop>
            <h3 class="font-heading text-lg text-pink-700 mb-4">Subir archivos</h3>

            <form method="POST" action="{{ route('admin.media.upload') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="border-2 border-dashed border-pink-200 rounded-xl p-8 text-center hover:border-pink-400 transition cursor-pointer relative"
                     @dragover.prevent="$el.classList.add('border-pink-500', 'bg-pink-50')"
                     @dragleave.prevent="$el.classList.remove('border-pink-500', 'bg-pink-50')"
                     @drop.prevent="$el.classList.remove('border-pink-500', 'bg-pink-50'); $refs.fileInput.files = $event.dataTransfer.files; $refs.fileCount.textContent = $event.dataTransfer.files.length + ' archivo(s)'"
                     @click="$refs.fileInput.click()">
                    <svg class="w-10 h-10 text-pink-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                    <p class="text-sm text-gray-600 mb-1">Arrastra archivos aquí o haz click para seleccionar</p>
                    <p class="text-xs text-gray-400">Máximo 10MB por archivo. Imágenes, PDF, documentos.</p>
                    <p x-ref="fileCount" class="text-xs text-pink-500 font-semibold mt-2"></p>
                    <input type="file" name="files[]" multiple x-ref="fileInput" class="hidden"
                           @change="$refs.fileCount.textContent = $el.files.length + ' archivo(s) seleccionado(s)'">
                </div>

                <div x-data="{
                        mode: 'select',
                        folder: @js($folder ?: 'general'),
                        newFolder: '',
                        folders: @js(array_values(array_unique(array_merge(['general'], $folders))))
                     }">
                    <div class="flex items-center justify-between mb-1">
                        <label class="text-xs uppercase tracking-widest text-gray-500 font-semibold">Carpeta</label>
                        <button type="button" x-show="mode === 'select'" @click="mode = 'new'; $nextTick(() => $refs.newInput.focus())" class="text-[10px] text-pink-500 hover:text-pink-700 font-bold uppercase tracking-widest">+ Nueva</button>
                        <button type="button" x-show="mode === 'new'" @click="mode = 'select'; newFolder = ''" class="text-[10px] text-gray-500 hover:text-gray-700 font-bold uppercase tracking-widest">Cancelar</button>
                    </div>
                    <select x-show="mode === 'select'" name="folder" x-model="folder" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 text-sm focus:border-pink-400 focus:outline-none bg-white">
                        <template x-for="f in folders" :key="f">
                            <option :value="f" x-text="f"></option>
                        </template>
                    </select>
                    <input x-show="mode === 'new'" x-ref="newInput" type="text" name="folder" x-model="newFolder" placeholder="Nombre de la nueva carpeta" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 text-sm focus:border-pink-400 focus:outline-none" x-cloak>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" @click="showUpload = false" class="px-4 py-2.5 text-sm text-gray-600 hover:text-gray-800">Cancelar</button>
                    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs uppercase tracking-widest px-6 py-2.5 rounded-xl transition">Subir</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Files grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
        @forelse($files as $file)
            <div class="group bg-white border border-pink-100 rounded-xl overflow-hidden hover:shadow-lg hover:shadow-pink-100/50 transition-all"
                 x-data="{ editing: false }">

                {{-- Thumbnail --}}
                <div class="aspect-square bg-pink-50 overflow-hidden relative">
                    @if($file->isImage())
                        <img src="{{ $file->url() }}" alt="{{ $file->alt ?? $file->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-pink-300">
                            <svg class="w-10 h-10 mb-1" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            <span class="text-[10px] uppercase tracking-widest font-bold">{{ pathinfo($file->filename, PATHINFO_EXTENSION) }}</span>
                        </div>
                    @endif

                    {{-- Actions overlay --}}
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                        <button @click="navigator.clipboard.writeText('{{ $file->url() }}'); $dispatch('notify', { message: 'URL copiada' })"
                                title="Copiar URL" class="p-2 bg-white rounded-lg shadow hover:bg-pink-50 transition">
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H6m8.25 12V18m0 0H9.75m3 0h3"/></svg>
                        </button>
                        <button @click="editing = true" title="Editar" class="p-2 bg-white rounded-lg shadow hover:bg-pink-50 transition">
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z"/></svg>
                        </button>
                        <form method="POST" action="{{ route('admin.media.destroy', $file) }}" onsubmit="return confirm('¿Eliminar?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" title="Eliminar" class="p-2 bg-white rounded-lg shadow hover:bg-red-50 transition">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- File info --}}
                <div class="p-2.5">
                    <p class="text-xs font-semibold text-gray-700 truncate" title="{{ $file->name }}">{{ $file->name }}</p>
                    <p class="text-[10px] text-gray-400">{{ $file->sizeForHumans() }}@if($file->width) · {{ $file->width }}×{{ $file->height }}@endif</p>
                </div>

                {{-- Edit inline form --}}
                <div x-show="editing" x-cloak class="p-3 border-t border-pink-100 bg-pink-50/50">
                    <form method="POST" action="{{ route('admin.media.update', $file) }}" class="space-y-2">
                        @csrf @method('PUT')
                        <input type="text" name="name" value="{{ $file->name }}" class="w-full border border-pink-200 rounded-lg px-2 py-1 text-xs focus:border-pink-400 focus:outline-none" placeholder="Nombre">
                        <input type="text" name="alt" value="{{ $file->alt }}" class="w-full border border-pink-200 rounded-lg px-2 py-1 text-xs focus:border-pink-400 focus:outline-none" placeholder="Texto alt">
                        <input type="text" name="folder" value="{{ $file->folder }}" class="w-full border border-pink-200 rounded-lg px-2 py-1 text-xs focus:border-pink-400 focus:outline-none" placeholder="Carpeta">
                        <div class="flex gap-2">
                            <button type="submit" class="bg-pink-500 text-white text-[10px] uppercase tracking-widest font-bold px-3 py-1 rounded-lg">Guardar</button>
                            <button type="button" @click="editing = false" class="text-gray-500 text-[10px] uppercase tracking-widest font-bold px-3 py-1">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <div class="mx-auto w-16 h-16 rounded-full bg-pink-50 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-pink-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 18.75h.008v.008H18v-.008zm-6 0h.008v.008H12v-.008z"/></svg>
                </div>
                <p class="text-gray-500 mb-2">No hay archivos todavía</p>
                <button @click="showUpload = true" class="text-pink-500 hover:text-pink-700 text-xs uppercase tracking-widest font-bold">Subir el primero</button>
            </div>
        @endforelse
    </div>

    @if($files->hasPages())
        <div class="mt-6">{{ $files->links() }}</div>
    @endif
</div>

<script>
function mediaManager() {
    return { showUpload: false };
}
</script>
@endsection
