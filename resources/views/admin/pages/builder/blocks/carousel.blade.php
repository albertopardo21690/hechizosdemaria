@if($editing)
    <div class="space-y-4 text-sm">
        <div class="grid md:grid-cols-4 gap-3">
            <label class="flex items-center gap-2">
                <input type="checkbox" wire:model.lazy="{{ $path }}.props.autoplay" class="accent-pink-500"> Autoplay
            </label>
            <label>
                <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Intervalo (s)</span>
                <input type="number" min="1" max="30" wire:model.lazy="{{ $path }}.props.interval" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs">
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" wire:model.lazy="{{ $path }}.props.arrows" class="accent-pink-500"> Flechas
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" wire:model.lazy="{{ $path }}.props.dots" class="accent-pink-500"> Puntos
            </label>
        </div>
        <label>
            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Altura</span>
            <select wire:model.lazy="{{ $path }}.props.height" class="w-full max-w-xs border border-gray-300 rounded-md px-3 py-2">
                <option value="sm">Baja (300px)</option>
                <option value="md">Media (500px)</option>
                <option value="lg">Alta (700px)</option>
                <option value="full">Pantalla completa</option>
            </select>
        </label>

        <div>
            <p class="text-xs uppercase tracking-widest text-gray-600 mb-2">Slides</p>
            <div class="space-y-2">
                @foreach(($block['props']['slides'] ?? []) as $idx => $slide)
                    <div class="bg-pink-50/40 border border-pink-200 rounded-md p-3 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-[10px] font-mono text-pink-600 uppercase tracking-widest">Slide {{ $idx + 1 }}</span>
                            <button type="button" wire:click="carouselRemoveSlide('{{ $block['id'] }}', {{ $idx }})" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                        </div>
                        @include('admin.pages.builder._image-field', [
                            'fieldId' => $path.'.props.slides.'.$idx.'.image',
                            'label' => 'Imagen',
                            'value' => $slide['image'] ?? '',
                        ])
                        <input type="text" wire:model.lazy="{{ $path }}.props.slides.{{ $idx }}.heading" placeholder="Título" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs font-heading">
                        <input type="text" wire:model.lazy="{{ $path }}.props.slides.{{ $idx }}.subheading" placeholder="Subtítulo" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs">
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" wire:model.lazy="{{ $path }}.props.slides.{{ $idx }}.cta_text" placeholder="Texto botón" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs">
                            <input type="text" wire:model.lazy="{{ $path }}.props.slides.{{ $idx }}.cta_url" placeholder="URL botón" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs font-mono">
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" wire:click="carouselAddSlide('{{ $block['id'] }}')" class="mt-2 w-full border-2 border-dashed border-pink-300 text-pink-600 py-2 rounded-md text-xs hover:bg-pink-50 uppercase tracking-widest font-semibold">+ Añadir slide</button>
        </div>
    </div>
@else
    <div class="text-xs text-gray-600">
        <p class="font-semibold">Carrusel · {{ count($block['props']['slides'] ?? []) }} slides</p>
        <p class="text-gray-400 text-[11px]">{{ ($block['props']['autoplay'] ?? false) ? 'Autoplay ' . ($block['props']['interval'] ?? 5).'s' : 'Manual' }}</p>
    </div>
@endif
