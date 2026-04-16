@if($editing)
    <div class="grid md:grid-cols-3 gap-3 text-sm">
        <label class="md:col-span-3"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Eyebrow</span><input type="text" wire:model.lazy="{{ $path }}.props.eyebrow" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
        <label class="md:col-span-3"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Texto *</span><input type="text" wire:model.lazy="{{ $path }}.props.text" class="w-full border border-gray-300 rounded-md px-3 py-2 font-heading"></label>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Alineación</span><select wire:model.lazy="{{ $path }}.props.align" class="w-full border border-gray-300 rounded-md px-3 py-2"><option value="left">Izquierda</option><option value="center">Centro</option></select></label>
        <label class="flex items-center gap-2 text-sm pt-5"><input type="checkbox" wire:model.lazy="{{ $path }}.props.divider" class="accent-pink-500"> Mostrar divisor dorado</label>
    </div>
@else
    <p class="font-heading text-lg text-pink-700">{{ $block['props']['text'] ?? '—' }}</p>
@endif
