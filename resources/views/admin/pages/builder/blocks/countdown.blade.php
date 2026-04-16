@if($editing)
    <div class="space-y-3 text-sm">
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Fecha / hora límite *</span>
            <input type="datetime-local" wire:model.lazy="{{ $path }}.props.due_date" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
        <div class="grid grid-cols-4 gap-2">
            <label><span class="block text-[10px] uppercase tracking-widest text-gray-600 mb-1">Días</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.label_days" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs"></label>
            <label><span class="block text-[10px] uppercase tracking-widest text-gray-600 mb-1">Horas</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.label_hours" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs"></label>
            <label><span class="block text-[10px] uppercase tracking-widest text-gray-600 mb-1">Minutos</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.label_minutes" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs"></label>
            <label><span class="block text-[10px] uppercase tracking-widest text-gray-600 mb-1">Segundos</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.label_seconds" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs"></label>
        </div>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Texto al finalizar</span>
            <input type="text" wire:model.lazy="{{ $path }}.props.expire_text" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
    </div>
@else
    <div class="text-xs text-gray-600"><p class="font-semibold">Cuenta atrás hasta {{ $block['props']['due_date'] ?? '—' }}</p></div>
@endif
