@if($editing)
    <div class="grid md:grid-cols-2 gap-3 text-sm">
        <label class="md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Título *</span><input type="text" wire:model.lazy="blocks.{{ $index }}.props.heading" class="w-full border border-gray-300 rounded-md px-3 py-2 font-heading"></label>
        <label class="md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Texto</span><textarea wire:model.lazy="blocks.{{ $index }}.props.body" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2"></textarea></label>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Botón 1 texto</span><input type="text" wire:model.lazy="blocks.{{ $index }}.props.primary_text" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Botón 1 URL</span><input type="text" wire:model.lazy="blocks.{{ $index }}.props.primary_url" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs"></label>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Botón 2 texto</span><input type="text" wire:model.lazy="blocks.{{ $index }}.props.secondary_text" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Botón 2 URL</span><input type="text" wire:model.lazy="blocks.{{ $index }}.props.secondary_url" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs"></label>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Fondo</span><select wire:model.lazy="blocks.{{ $index }}.props.background" class="w-full border border-gray-300 rounded-md px-3 py-2"><option value="pink">Rosa degradado</option><option value="white">Blanco</option><option value="light">Rosa claro</option></select></label>
    </div>
@else
    <p class="font-heading text-base text-pink-700">{{ $block['props']['heading'] ?? '—' }}</p>
@endif
