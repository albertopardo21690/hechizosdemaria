@php
    $source = $source ?? 'name';
    $slug = $slug ?? '';
    $sourceValue = $sourceValue ?? '';
    $urlPrefix = $urlPrefix ?? '/';
    $required = $required ?? true;
@endphp
<div x-data="{
    src: @js($sourceValue),
    slug: @js($slug),
    manual: {{ $slug ? 'true' : 'false' }},
    slugify(t) {
        return (t || '').toString().toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '')
            .substring(0, 80);
    },
    init() {
        const srcInput = document.querySelector('[name=\'{{ $source }}\']');
        if (srcInput) {
            srcInput.addEventListener('input', (e) => {
                this.src = e.target.value;
                if (!this.manual) this.slug = this.slugify(this.src);
            });
        }
        if (!this.slug && this.src) this.slug = this.slugify(this.src);
    }
}">
    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Slug (automático)</label>
    <input type="text" name="slug" x-model="slug" :readonly="!manual" @if($required) required @endif
           class="w-full border rounded-md px-3 py-2 font-mono text-sm transition"
           :class="manual ? 'border-pink-500 bg-white focus:outline-none focus:border-pink-600' : 'border-gray-200 bg-gray-50 text-gray-600 cursor-not-allowed'">
    <div class="flex items-center justify-between mt-1 text-xs flex-wrap gap-2">
        <p class="text-gray-500">URL completa: <code class="text-pink-700 break-all">{{ rtrim(config('app.url'), '/') }}{{ $urlPrefix }}<strong x-text="slug || '...'"></strong></code></p>
        <button type="button" @click="manual = !manual; if(!manual) slug = slugify(src)" class="text-pink-600 hover:text-pink-800 uppercase tracking-widest font-semibold text-[10px] shrink-0">
            <span x-show="!manual">🔓 Editar manualmente</span>
            <span x-show="manual" x-cloak>🔒 Volver a automático</span>
        </button>
    </div>
</div>
