<div>
    @if($open)
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-4" @keydown.escape.window="$wire.set('open', false)">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40" wire:click="$set('open', false)"></div>

        {{-- Modal --}}
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[85vh] flex flex-col overflow-hidden" @click.stop>

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-pink-100 flex-shrink-0">
                <h2 class="font-heading text-lg text-pink-700">Gestor de archivos</h2>
                <div class="flex items-center gap-4">
                    {{-- Tabs --}}
                    <div class="flex bg-pink-50 rounded-lg p-0.5">
                        <button wire:click="$set('tab', 'library')" class="px-4 py-1.5 rounded-md text-xs font-bold uppercase tracking-widest transition {{ $tab === 'library' ? 'bg-white text-pink-700 shadow-sm' : 'text-gray-500 hover:text-pink-600' }}">Biblioteca</button>
                        <button wire:click="$set('tab', 'upload')" class="px-4 py-1.5 rounded-md text-xs font-bold uppercase tracking-widest transition {{ $tab === 'upload' ? 'bg-white text-pink-700 shadow-sm' : 'text-gray-500 hover:text-pink-600' }}">Subir</button>
                    </div>
                    <button wire:click="$set('open', false)" class="p-1.5 rounded-lg hover:bg-pink-50 text-gray-400 hover:text-pink-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Library tab --}}
            @if($tab === 'library')
                {{-- Filters --}}
                <div class="flex items-center gap-3 px-6 py-3 border-b border-pink-50 flex-shrink-0">
                    <div class="relative flex-1 max-w-xs">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar..."
                               class="w-full border border-pink-200 rounded-lg pl-9 pr-3 py-2 text-sm focus:border-pink-400 focus:outline-none">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-pink-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </div>
                    <select wire:model.live="folder" class="border border-pink-200 rounded-lg px-3 py-2 text-sm focus:border-pink-400 focus:outline-none bg-white">
                        <option value="">Todas las carpetas</option>
                        @foreach($folders as $f)
                            <option value="{{ $f }}">{{ $f }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Files grid --}}
                <div class="flex-1 overflow-y-auto p-6">
                    <div wire:loading.delay class="text-center py-8 text-pink-400 text-sm">Cargando...</div>

                    <div wire:loading.remove class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3">
                        @forelse($files as $file)
                            <button type="button" wire:click="selectFile({{ $file->id }})"
                                    class="group bg-white border border-pink-100 rounded-xl overflow-hidden hover:border-pink-500 hover:shadow-md transition-all text-left">
                                <div class="aspect-square bg-pink-50 overflow-hidden">
                                    @if($file->isImage())
                                        <img src="{{ $file->url() }}" alt="{{ $file->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-pink-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                            <span class="text-[9px] uppercase tracking-widest font-bold mt-1">{{ pathinfo($file->filename, PATHINFO_EXTENSION) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-2">
                                    <p class="text-[10px] font-semibold text-gray-700 truncate">{{ $file->name }}</p>
                                    <p class="text-[9px] text-gray-400">{{ $file->sizeForHumans() }}</p>
                                </div>
                            </button>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-sm text-gray-400 mb-2">No hay archivos</p>
                                <button type="button" wire:click="$set('tab', 'upload')" class="text-pink-500 text-xs font-bold uppercase tracking-widest">Subir el primero</button>
                            </div>
                        @endforelse
                    </div>

                    @if($files->hasPages())
                        <div class="mt-4">{{ $files->links() }}</div>
                    @endif
                </div>
            @endif

            {{-- Upload tab --}}
            @if($tab === 'upload')
                <div class="flex-1 overflow-y-auto p-6">
                    <form wire:submit="uploadFiles" class="space-y-4">
                        <div class="border-2 border-dashed border-pink-200 rounded-xl p-10 text-center hover:border-pink-400 transition cursor-pointer"
                             x-data
                             @click="$refs.pickerUpload.click()"
                             @dragover.prevent="$el.classList.add('border-pink-500', 'bg-pink-50')"
                             @dragleave.prevent="$el.classList.remove('border-pink-500', 'bg-pink-50')"
                             @drop.prevent="$el.classList.remove('border-pink-500', 'bg-pink-50')">
                            <svg class="w-12 h-12 text-pink-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                            <p class="text-sm text-gray-600 mb-1">Arrastra archivos aquí o haz click</p>
                            <p class="text-xs text-gray-400">Imágenes, PDF, documentos. Máximo 10MB cada uno.</p>
                            <input type="file" x-ref="pickerUpload" wire:model="uploads" multiple class="hidden">
                        </div>

                        {{-- Upload progress --}}
                        <div wire:loading wire:target="uploads" class="text-center text-sm text-pink-500">
                            <svg class="w-5 h-5 animate-spin inline mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            Subiendo...
                        </div>

                        {{-- Preview of selected files --}}
                        @if(count($uploads))
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($uploads as $i => $file)
                                    <div class="aspect-square bg-pink-50 rounded-lg overflow-hidden border border-pink-200">
                                        @if(str_starts_with($file->getMimeType(), 'image/'))
                                            <img src="{{ $file->temporaryUrl() }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-pink-300 text-xs font-bold uppercase">{{ $file->getClientOriginalExtension() }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div x-data="{
                                mode: 'select',
                                folders: @js(array_values(array_unique(array_merge(['general'], $folders))))
                             }">
                            <div class="flex items-center justify-between mb-1">
                                <label class="text-xs uppercase tracking-widest text-gray-500 font-semibold">Carpeta</label>
                                <button type="button" x-show="mode === 'select'" @click="mode = 'new'; $wire.set('uploadFolder', ''); $nextTick(() => $refs.newInput.focus())" class="text-[10px] text-pink-500 hover:text-pink-700 font-bold uppercase tracking-widest">+ Nueva</button>
                                <button type="button" x-show="mode === 'new'" @click="mode = 'select'; $wire.set('uploadFolder', 'general')" class="text-[10px] text-gray-500 hover:text-gray-700 font-bold uppercase tracking-widest">Cancelar</button>
                            </div>
                            <select x-show="mode === 'select'" wire:model.live="uploadFolder" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 text-sm focus:border-pink-400 focus:outline-none bg-white">
                                <template x-for="f in folders" :key="f">
                                    <option :value="f" x-text="f"></option>
                                </template>
                            </select>
                            <input x-show="mode === 'new'" x-ref="newInput" type="text" wire:model.live="uploadFolder" placeholder="Nombre de la nueva carpeta" class="w-full border border-pink-200 rounded-xl px-4 py-2.5 text-sm focus:border-pink-400 focus:outline-none" x-cloak>
                        </div>

                        @error('uploads.*')<p class="text-xs text-red-500">{{ $message }}</p>@enderror

                        <button type="submit" wire:loading.attr="disabled" class="w-full bg-pink-500 hover:bg-pink-600 disabled:bg-pink-300 text-white font-bold text-xs uppercase tracking-widest py-3 rounded-xl transition shadow-lg shadow-pink-500/20">
                            Subir y seleccionar
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>
