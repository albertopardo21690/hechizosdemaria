@if($editing)
    <div class="space-y-3">
        <label class="block max-w-xs text-sm"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Columnas</span><select wire:model.lazy="{{ $path }}.props.columns" class="w-full border border-gray-300 rounded-md px-3 py-2"><option value="2">2</option><option value="3">3</option><option value="4">4</option></select></label>
        @foreach($block['props']['images'] as $idx => $img)
            <div class="flex gap-2 items-start border border-pink-200 rounded-md p-2">
                <div class="flex-1 space-y-2">
                    @include('admin.pages.builder._image-field', [
                        'fieldId' => $path.'.props.images.'.$idx.'.src',
                        'label' => 'Imagen '.($idx + 1),
                        'value' => $img['src'] ?? '',
                    ])
                    <input type="text" wire:model.lazy="{{ $path }}.props.images.{{ $idx }}.alt" placeholder="Texto alt" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                </div>
                <button type="button" wire:click="removeGalleryImage('{{ $block['id'] }}', {{ $idx }})" class="text-red-500 hover:text-red-700 px-2 py-2 flex-shrink-0">&times;</button>
            </div>
        @endforeach
        <button type="button" wire:click="addGalleryImage('{{ $block['id'] }}')" class="w-full border-2 border-dashed border-pink-300 text-pink-600 py-2 rounded-md text-sm hover:bg-pink-50 uppercase tracking-widest font-semibold">+ Añadir imagen</button>
    </div>
@else
    <p class="text-sm text-gray-600">{{ count($block['props']['images'] ?? []) }} imágenes · {{ $block['props']['columns'] }} columnas</p>
@endif
