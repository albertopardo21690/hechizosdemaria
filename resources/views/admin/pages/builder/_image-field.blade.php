{{--
    Reusable image field with media picker integration.
    Required: $fieldId (unique wire:model path), $label (field label), $value (current URL)
    Optional: $placeholder
--}}
@php
    $fieldId = $fieldId ?? 'image_url';
    $label = $label ?? 'Imagen';
    $value = $value ?? '';
    $placeholder = $placeholder ?? 'URL de la imagen';
@endphp

<div x-data="{
        preview: @js($value),
        field: @js($fieldId),
        init() {
            Livewire.on('media-selected', (data) => {
                if (data.field === this.field) {
                    this.preview = data.url;
                }
            });
        }
     }" class="space-y-2">
    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">{{ $label }}</label>

    {{-- Preview --}}
    <template x-if="preview">
        <div class="relative rounded-lg overflow-hidden border border-pink-200 bg-pink-50 mb-2" style="max-height: 160px;">
            <img :src="preview" class="w-full object-cover" style="max-height: 160px;" x-on:error="$el.style.display='none'">
            <button type="button" @click="preview = ''; $wire.set(field, '')" class="absolute top-2 right-2 p-1 bg-white/90 rounded-full shadow hover:bg-red-50 transition">
                <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </template>

    {{-- Input + picker button --}}
    <div class="flex gap-2">
        <input type="text"
               x-model="preview"
               @input.debounce.500ms="$wire.set(field, preview)"
               placeholder="{{ $placeholder }}"
               class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-xs font-mono focus:border-pink-500 focus:outline-none">
        <button type="button"
                @click="Livewire.dispatch('open-media-picker', { field: field })"
                class="flex-shrink-0 bg-pink-50 hover:bg-pink-100 border border-pink-200 text-pink-600 rounded-md px-3 py-2 transition"
                title="Abrir gestor de archivos">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 18.75h.008v.008H18v-.008zm-6 0h.008v.008H12v-.008z"/></svg>
        </button>
    </div>
</div>
