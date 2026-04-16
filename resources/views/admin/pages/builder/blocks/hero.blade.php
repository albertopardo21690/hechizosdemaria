@if($editing)
    <div class="grid md:grid-cols-2 gap-3 text-sm">
        <label class="block"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Eyebrow</span><input type="text" wire:model.lazy="{{ $path }}.props.eyebrow" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
        <label class="block"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Alineación</span><select wire:model.lazy="{{ $path }}.props.align" class="w-full border border-gray-300 rounded-md px-3 py-2"><option value="left">Izquierda</option><option value="center">Centro</option></select></label>
        <label class="block md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Título *</span><input type="text" wire:model.lazy="{{ $path }}.props.heading" class="w-full border border-gray-300 rounded-md px-3 py-2 font-heading"></label>
        <label class="block md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Subtítulo</span><input type="text" wire:model.lazy="{{ $path }}.props.subheading" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
        <label class="block md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Cuerpo</span><textarea wire:model.lazy="{{ $path }}.props.body" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2"></textarea></label>
        <label class="block md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Imagen (URL)</span><input type="text" wire:model.lazy="{{ $path }}.props.image" placeholder="/images/branding/about.jpg" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs"></label>
        <label class="block"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Texto del botón</span><input type="text" wire:model.lazy="{{ $path }}.props.cta_text" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
        <label class="block"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">URL del botón</span><input type="text" wire:model.lazy="{{ $path }}.props.cta_url" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs"></label>
    </div>
    @include('admin.pages.builder.dynamic-vars-help')
@else
    <div class="text-sm text-gray-600">
        <p class="font-heading text-lg text-pink-700">{{ $block['props']['heading'] ?? '—' }}</p>
        @if($block['props']['subheading'] ?? null)<p class="text-xs text-gray-500 mt-1">{{ $block['props']['subheading'] }}</p>@endif
        @if($block['props']['image'] ?? null)<p class="text-xs text-gray-400 mt-1 font-mono">🖼 {{ Str::limit($block['props']['image'], 50) }}</p>@endif
    </div>
@endif
