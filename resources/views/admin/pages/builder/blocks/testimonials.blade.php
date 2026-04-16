@if($editing)
    <div class="space-y-3 text-sm">
        <label class="block"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Título de la sección</span><input type="text" wire:model.lazy="blocks.{{ $index }}.props.title" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
        <label class="flex items-center gap-2"><input type="checkbox" wire:model.lazy="blocks.{{ $index }}.props.only_featured" class="accent-pink-500"> Mostrar solo destacados y aprobados</label>
        @if(!$block['props']['only_featured'])
            <div>
                <p class="block text-xs uppercase tracking-widest text-gray-600 mb-2">Selección manual:</p>
                <div class="max-h-64 overflow-y-auto space-y-1 border border-pink-200 rounded-md p-2">
                    @forelse($testimonialsList as $t)
                        <label class="flex gap-2 items-start py-1 hover:bg-pink-50 px-2 rounded">
                            <input type="checkbox" wire:model.lazy="blocks.{{ $index }}.props.ids" value="{{ $t->id }}" class="accent-pink-500 mt-1">
                            <span class="flex-1"><strong>{{ $t->name }}</strong><br><span class="text-xs text-gray-500">{{ Str::limit($t->text, 60) }}</span></span>
                        </label>
                    @empty
                        <p class="text-xs text-gray-500 py-2">Aún no hay testimonios creados. <a href="{{ route('admin.testimonials.create') }}" class="text-pink-600 underline">Crear uno</a>.</p>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
@else
    <p class="text-sm text-gray-600">
        @if($block['props']['only_featured'])
            Testimonios destacados aprobados (automático)
        @else
            {{ count($block['props']['ids'] ?? []) }} testimonio(s) seleccionado(s)
        @endif
    </p>
@endif
