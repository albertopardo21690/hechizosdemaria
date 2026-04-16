@if($editing)
    <div class="space-y-3 text-sm">
        <div class="grid md:grid-cols-2 gap-3">
            <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Icono</span>
                <select wire:model.lazy="{{ $path }}.props.icon" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="sparkle">✨ Chispa</option>
                    <option value="star">⭐ Estrella</option>
                    <option value="heart">❤ Corazón</option>
                    <option value="moon">🌙 Luna</option>
                    <option value="sun">☀ Sol</option>
                    <option value="flame">🔥 Llama</option>
                    <option value="eye">👁 Ojo</option>
                    <option value="hand">✋ Mano</option>
                    <option value="lock">🔒 Candado</option>
                    <option value="check">✓ Check</option>
                </select></label>
            <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Alineación</span>
                <select wire:model.lazy="{{ $path }}.props.align" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="left">Izquierda</option>
                    <option value="center">Centro</option>
                    <option value="right">Derecha</option>
                </select></label>
            <label class="md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Título *</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.title" class="w-full border border-gray-300 rounded-md px-3 py-2 font-heading"></label>
            <label class="md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Descripción</span>
                <textarea wire:model.lazy="{{ $path }}.props.body" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2"></textarea></label>
            <label class="md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">URL (opcional)</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.url" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs"></label>
        </div>
    </div>
@else
    <div class="text-xs text-gray-600"><p><strong>{{ $block['props']['title'] ?? '' }}</strong></p><p class="text-gray-400">{{ Str::limit($block['props']['body'] ?? '', 60) }}</p></div>
@endif
