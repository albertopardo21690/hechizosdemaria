@if($editing)
    <label class="block text-sm">
        <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">HTML / Texto</span>
        <textarea wire:model.lazy="{{ $path }}.props.html" rows="10" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs"></textarea>
        <span class="block text-xs text-gray-500 mt-1">Permite HTML: &lt;p&gt;, &lt;strong&gt;, &lt;a&gt;, &lt;ul&gt;, &lt;li&gt;, etc.</span>
    </label>
    @include('admin.pages.builder.dynamic-vars-help')
@else
    <div class="prose prose-sm max-w-none text-gray-700">{!! Str::limit(strip_tags($block['props']['html'] ?? ''), 200) !!}</div>
@endif
