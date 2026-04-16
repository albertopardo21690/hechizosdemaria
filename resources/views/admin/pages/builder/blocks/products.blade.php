@if($editing)
    <div class="grid md:grid-cols-2 gap-3 text-sm">
        <label class="md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Título</span><input type="text" wire:model.lazy="blocks.{{ $index }}.props.title" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Colección</span>
            <select wire:model.lazy="blocks.{{ $index }}.props.collection_slug" class="w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="">— Seleccionar —</option>
                @foreach($collectionsList as $c)
                    <option value="{{ $c->slug }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </label>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Cantidad</span><input type="number" min="1" max="12" wire:model.lazy="blocks.{{ $index }}.props.limit" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
    </div>
@else
    <p class="text-sm text-gray-600">{{ $block['props']['limit'] ?? 4 }} productos de <strong>{{ $block['props']['collection_slug'] ?: '(sin colección)' }}</strong></p>
@endif
