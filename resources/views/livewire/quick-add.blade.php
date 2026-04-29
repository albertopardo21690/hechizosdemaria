<div>
    @if($show)
        <div x-data="{ open: true }" x-show="open" x-init="setTimeout(() => open = false, 3000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-4 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-4 opacity-0"
             class="fixed bottom-6 right-6 z-50 bg-white border border-pink-200 shadow-2xl rounded-xl px-5 py-4 flex items-center gap-3 max-w-sm"
             wire:key="toast-{{ now()->timestamp }}">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ $productName }}</p>
                <p class="text-xs text-gray-500">Añadido al carrito</p>
            </div>
            <a href="{{ route('cart') }}" class="text-pink-500 hover:text-pink-700 text-xs font-bold uppercase tracking-widest whitespace-nowrap">Ver</a>
        </div>
    @endif
</div>
