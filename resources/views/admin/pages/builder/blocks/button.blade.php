@if($editing)
    <div class="space-y-3 text-sm">
        <div class="grid md:grid-cols-2 gap-3">
            <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Texto *</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.text" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
            <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">URL *</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.url" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs"></label>
            <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Estilo</span>
                <select wire:model.lazy="{{ $path }}.props.style" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="solid">Sólido</option>
                    <option value="outline">Contorno</option>
                    <option value="ghost">Ghost</option>
                </select></label>
            <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Color</span>
                <select wire:model.lazy="{{ $path }}.props.color" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="pink">Rosa</option>
                    <option value="black">Negro</option>
                    <option value="white">Blanco</option>
                    <option value="gold">Dorado</option>
                </select></label>
            <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Tamaño</span>
                <select wire:model.lazy="{{ $path }}.props.size" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="sm">Pequeño</option>
                    <option value="md">Medio</option>
                    <option value="lg">Grande</option>
                </select></label>
            <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Alineación</span>
                <select wire:model.lazy="{{ $path }}.props.align" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="left">Izquierda</option>
                    <option value="center">Centro</option>
                    <option value="right">Derecha</option>
                </select></label>
            <label class="flex items-center gap-2 pt-5">
                <input type="checkbox" wire:model.lazy="{{ $path }}.props.target_blank" class="accent-pink-500"> Abrir en nueva pestaña</label>
            <label class="flex items-center gap-2 pt-5">
                <input type="checkbox" wire:model.lazy="{{ $path }}.props.full_width" class="accent-pink-500"> Ancho completo</label>
        </div>
    </div>
@else
    <div class="text-xs text-gray-600">
        <p><strong>{{ $block['props']['text'] ?? '' }}</strong> → {{ Str::limit($block['props']['url'] ?? '', 40) }}</p>
    </div>
@endif
