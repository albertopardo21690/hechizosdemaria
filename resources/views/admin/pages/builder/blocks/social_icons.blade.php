@if($editing)
    <div class="space-y-3 text-sm">
        <div class="grid md:grid-cols-4 gap-3">
            <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Tamaño</span>
                <select wire:model.lazy="{{ $path }}.props.size" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs">
                    <option value="sm">Pequeño</option>
                    <option value="md">Medio</option>
                    <option value="lg">Grande</option>
                </select></label>
            <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Estilo</span>
                <select wire:model.lazy="{{ $path }}.props.style" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs">
                    <option value="round">Redondo</option>
                    <option value="square">Cuadrado</option>
                    <option value="flat">Sin fondo</option>
                </select></label>
            <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Color</span>
                <select wire:model.lazy="{{ $path }}.props.color" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs">
                    <option value="pink">Rosa</option>
                    <option value="black">Negro</option>
                    <option value="brand">Color marca</option>
                </select></label>
            <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Alineación</span>
                <select wire:model.lazy="{{ $path }}.props.align" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs">
                    <option value="left">Izquierda</option>
                    <option value="center">Centro</option>
                    <option value="right">Derecha</option>
                </select></label>
        </div>
        <div class="space-y-1">
            @foreach(($block['props']['icons'] ?? []) as $idx => $icon)
                <div class="flex gap-2 items-center bg-pink-50/40 border border-pink-200 rounded-md p-2">
                    <select wire:model.lazy="{{ $path }}.props.icons.{{ $idx }}.platform" class="border border-gray-300 rounded-md px-2 py-1.5 text-xs">
                        <option value="instagram">Instagram</option>
                        <option value="tiktok">TikTok</option>
                        <option value="youtube">YouTube</option>
                        <option value="facebook">Facebook</option>
                        <option value="twitter">Twitter/X</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="telegram">Telegram</option>
                        <option value="pinterest">Pinterest</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="email">Email</option>
                    </select>
                    <input type="text" wire:model.lazy="{{ $path }}.props.icons.{{ $idx }}.url" placeholder="URL" class="flex-1 border border-gray-300 rounded-md px-2 py-1.5 text-xs font-mono">
                    <button type="button" wire:click="socialRemoveIcon('{{ $block['id'] }}', {{ $idx }})" class="text-red-500 hover:text-red-700 px-2">&times;</button>
                </div>
            @endforeach
        </div>
        <button type="button" wire:click="socialAddIcon('{{ $block['id'] }}')" class="w-full border-2 border-dashed border-pink-300 text-pink-600 py-2 rounded-md text-xs hover:bg-pink-50 uppercase tracking-widest font-semibold">+ Añadir red</button>
    </div>
@else
    <div class="text-xs text-gray-600"><p class="font-semibold">Sociales · {{ count($block['props']['icons'] ?? []) }} iconos</p></div>
@endif
