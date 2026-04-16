@php $items = $block['props']['items'] ?? []; @endphp
<div x-data="{ active: 0 }" class="bg-white border border-pink-100 rounded-xl overflow-hidden">
    <div class="flex border-b border-pink-200 overflow-x-auto">
        @foreach($items as $i => $item)
            <button type="button" @click="active = {{ $i }}" :class="active === {{ $i }} ? 'border-pink-500 text-pink-700 bg-pink-50/50' : 'border-transparent text-gray-500 hover:text-pink-600'" class="px-5 py-3 text-sm font-semibold border-b-2 transition whitespace-nowrap">
                {{ \App\Support\DynamicContent::render($item['label'] ?? ('Tab '.($i+1))) }}
            </button>
        @endforeach
    </div>
    <div class="p-5">
        @foreach($items as $i => $item)
            <div x-show="active === {{ $i }}" x-cloak class="prose prose-pink max-w-none text-gray-700 text-sm leading-relaxed">
                {!! \App\Support\DynamicContent::render($item['body'] ?? '') !!}
            </div>
        @endforeach
    </div>
</div>
