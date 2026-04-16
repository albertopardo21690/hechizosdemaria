<form action="{{ $block['props']['action'] ?? '/tienda' }}" method="GET" class="flex items-center w-full">
    <input type="text" name="q" placeholder="{{ $block['props']['placeholder'] ?? 'Buscar...' }}" class="flex-1 border border-pink-200 rounded-l-md px-3 py-2 text-sm focus:border-pink-500 focus:outline-none">
    <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-3 py-2 rounded-r-md">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    </button>
</form>
