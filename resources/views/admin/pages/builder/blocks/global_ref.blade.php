@php $allTemplates = \App\Models\PageTemplate::where('kind', 'section')->orderBy('name')->get(['id', 'name']); @endphp
@if($editing)
    <div class="space-y-3 text-sm">
        <label class="block">
            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Plantilla global referenciada *</span>
            <select wire:model.lazy="{{ $path }}.props.template_id" class="w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="">— Selecciona una plantilla —</option>
                @foreach($allTemplates as $tpl)
                    <option value="{{ $tpl->id }}">{{ $tpl->name }} (#{{ $tpl->id }})</option>
                @endforeach
            </select>
        </label>
        <p class="text-[11px] text-pink-500">⚡ Vinculado. Al editar la plantilla en "Plantillas guardadas" se actualizan todas las instancias. Guárdala como plantilla primero desde el botón 🏷 de cualquier sección.</p>
        @if($block['props']['template_id'] ?? null)
            <a href="#" onclick="return false" class="text-xs text-gray-500">Ref: #{{ $block['props']['template_id'] }}</a>
        @endif
    </div>
@else
    @php
        $tid = $block['props']['template_id'] ?? null;
        $name = $tid ? ($allTemplates->firstWhere('id', $tid)?->name ?? '(eliminada)') : null;
    @endphp
    <div class="text-xs text-gray-600">
        <p class="font-semibold">⚡ Widget global{{ $name ? ': '.$name : '' }}</p>
        @if(! $tid)<p class="text-red-500 text-[10px] mt-1">⚠ Sin plantilla seleccionada. Edita el widget y elige una.</p>@endif
    </div>
@endif
