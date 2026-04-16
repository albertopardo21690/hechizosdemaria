@if($editing)
    <div class="space-y-4 text-sm">
        <div class="grid md:grid-cols-2 gap-3">
            <label>
                <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Identificador interno</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.form_name" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs" placeholder="contacto, newsletter, reserva...">
            </label>
            <label>
                <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Email destino (opcional)</span>
                <input type="email" wire:model.lazy="{{ $path }}.props.email_to" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="hola@hechizosdemaria.com">
            </label>
            <label>
                <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Webhook URL (opcional)</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.webhook_url" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs" placeholder="https://hooks.zapier.com/...">
            </label>
            <label>
                <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Redirigir a URL tras envío (opcional)</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.redirect_url" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs" placeholder="/gracias">
            </label>
            <label>
                <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Texto del botón</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.submit_text" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </label>
            <label>
                <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Mensaje de éxito</span>
                <input type="text" wire:model.lazy="{{ $path }}.props.success_message" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </label>
        </div>

        <div>
            <p class="text-xs uppercase tracking-widest text-gray-600 mb-2">Campos del formulario</p>
            <div class="space-y-2">
                @foreach(($block['props']['fields'] ?? []) as $idx => $field)
                    <div class="bg-pink-50/40 border border-pink-200 rounded-md p-3">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <span class="text-[10px] font-mono text-pink-600 uppercase tracking-widest">Campo {{ $idx + 1 }}</span>
                            <button type="button" wire:click="formRemoveField('{{ $block['id'] }}', {{ $idx }})" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                        </div>
                        <div class="grid md:grid-cols-2 gap-2">
                            <label>
                                <span class="block text-[10px] uppercase tracking-widest text-gray-500 mb-1">Tipo</span>
                                <select wire:model.lazy="{{ $path }}.props.fields.{{ $idx }}.type" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs">
                                    <option value="text">Texto</option>
                                    <option value="email">Email</option>
                                    <option value="tel">Teléfono</option>
                                    <option value="textarea">Párrafo</option>
                                    <option value="select">Selector</option>
                                    <option value="checkbox">Casilla</option>
                                </select>
                            </label>
                            <label>
                                <span class="block text-[10px] uppercase tracking-widest text-gray-500 mb-1">Label visible</span>
                                <input type="text" wire:model.lazy="{{ $path }}.props.fields.{{ $idx }}.label" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs">
                            </label>
                            <label>
                                <span class="block text-[10px] uppercase tracking-widest text-gray-500 mb-1">Nombre técnico (name=)</span>
                                <input type="text" wire:model.lazy="{{ $path }}.props.fields.{{ $idx }}.name" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs font-mono">
                            </label>
                            <label>
                                <span class="block text-[10px] uppercase tracking-widest text-gray-500 mb-1">Placeholder</span>
                                <input type="text" wire:model.lazy="{{ $path }}.props.fields.{{ $idx }}.placeholder" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs">
                            </label>
                            <label class="flex items-center gap-2 text-xs md:col-span-2">
                                <input type="checkbox" wire:model.lazy="{{ $path }}.props.fields.{{ $idx }}.required" class="accent-pink-500"> Campo obligatorio
                            </label>
                            @if(($field['type'] ?? 'text') === 'select')
                                <label class="md:col-span-2">
                                    <span class="block text-[10px] uppercase tracking-widest text-gray-500 mb-1">Opciones (una por línea)</span>
                                    <textarea wire:model.lazy="{{ $path }}.props.fields.{{ $idx }}.options" rows="3" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs font-mono"></textarea>
                                </label>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" wire:click="formAddField('{{ $block['id'] }}')" class="mt-2 w-full border-2 border-dashed border-pink-300 text-pink-600 py-2 rounded-md text-xs hover:bg-pink-50 uppercase tracking-widest font-semibold">+ Añadir campo</button>
        </div>

        <p class="text-[11px] text-pink-500">Los envíos se guardan en Admin → Envíos de formulario y se pueden reenviar por email.</p>
    </div>
@else
    <div class="text-xs text-gray-600">
        <p class="font-semibold mb-1">Formulario "{{ $block['props']['form_name'] ?? 'sin-nombre' }}" · {{ count($block['props']['fields'] ?? []) }} campos</p>
        <p class="text-gray-400 truncate">{{ collect($block['props']['fields'] ?? [])->pluck('label')->implode(' · ') }}</p>
    </div>
@endif
