@if($editing)
    <label class="block text-sm">
        <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">HTML crudo</span>
        <textarea wire:model.lazy="{{ $path }}.props.html" rows="8" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs"></textarea>
        <span class="block text-xs text-amber-600 mt-1">⚠ Úsalo con cuidado. Se inserta tal cual en la página.</span>
    </label>
@else
    <p class="text-xs text-gray-500 font-mono">{{ Str::limit($block['props']['html'] ?? '', 80) }}</p>
@endif
