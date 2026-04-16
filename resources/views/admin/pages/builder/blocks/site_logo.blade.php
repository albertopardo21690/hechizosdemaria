@if($editing)
    <div class="grid md:grid-cols-3 gap-3 text-sm">
        <label>
            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Altura máx. (px)</span>
            <input type="number" min="16" max="200" wire:model.lazy="{{ $path }}.props.max_height" class="w-full border border-gray-300 rounded-md px-3 py-2">
        </label>
        <label>
            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Alineación</span>
            <select wire:model.lazy="{{ $path }}.props.align" class="w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="left">Izquierda</option>
                <option value="center">Centro</option>
                <option value="right">Derecha</option>
            </select>
        </label>
        <label class="flex items-center gap-2 pt-5">
            <input type="checkbox" wire:model.lazy="{{ $path }}.props.link_home" class="accent-pink-500"> Enlace a home
        </label>
    </div>
    <p class="text-[11px] text-gray-500 mt-2">El logo se toma de Branding. Sube el archivo desde el apartado Branding si aún no lo has hecho.</p>
@else
    <div class="text-xs text-gray-500">
        <p><strong>Logo del sitio</strong> · altura {{ $block['props']['max_height'] ?? 64 }}px · {{ $block['props']['align'] ?? 'left' }}</p>
    </div>
@endif
