@if($editing)
    <div class="space-y-3 text-sm">
        <label class="block"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Cita *</span><textarea wire:model.lazy="{{ $path }}.props.text" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 font-heading italic"></textarea></label>
        <label class="block"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Autor</span><input type="text" wire:model.lazy="{{ $path }}.props.author" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
    </div>
@else
    <p class="font-heading italic text-gray-700">"{{ Str::limit($block['props']['text'] ?? '', 100) }}"</p>
    @if($block['props']['author'] ?? null)<p class="text-xs text-pink-600 mt-1">— {{ $block['props']['author'] }}</p>@endif
@endif
