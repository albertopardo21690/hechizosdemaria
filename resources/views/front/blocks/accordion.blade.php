@php
    $p = $block['props'];
    $items = $p['items'] ?? [];
    $openFirst = $p['open_first'] ?? true;
@endphp
<div x-data="{ open: {{ $openFirst ? 0 : 'null' }} }" class="divide-y divide-pink-100 border border-pink-100 rounded-xl overflow-hidden bg-white">
    @foreach($items as $i => $item)
        <div>
            <button type="button" @click="open === {{ $i }} ? open = null : open = {{ $i }}" class="w-full flex items-center justify-between gap-4 px-5 py-4 text-left hover:bg-pink-50/40 transition">
                <span class="font-heading text-pink-700 text-base md:text-lg">{{ \App\Support\DynamicContent::render($item['title'] ?? '') }}</span>
                <svg class="w-5 h-5 text-pink-500 transition-transform shrink-0" :class="open === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open === {{ $i }}" x-transition x-cloak class="px-5 pb-5 text-sm text-gray-700 leading-relaxed">
                {!! \App\Support\DynamicContent::render($item['body'] ?? '') !!}
            </div>
        </div>
    @endforeach
</div>
