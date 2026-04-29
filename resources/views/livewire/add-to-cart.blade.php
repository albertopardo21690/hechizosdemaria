<div class="flex items-center gap-3">
    @if($added)
        <div class="flex items-center gap-2 text-green-600 font-semibold text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            Añadido al carrito
        </div>
        <a href="{{ route('cart') }}" class="text-pink-500 hover:text-pink-700 text-xs uppercase tracking-widest font-bold">Ver carrito →</a>
    @else
        <div class="flex items-center bg-pink-50 border border-pink-200 rounded-xl overflow-hidden">
            <button type="button" wire:click="$set('quantity', Math.max(1, {{ $quantity }} - 1))" class="px-3.5 py-3 text-pink-500 hover:bg-pink-100 transition font-bold">&minus;</button>
            <input type="number" min="1" wire:model="quantity" class="w-12 bg-transparent text-center text-gray-800 font-semibold outline-none py-3 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
            <button type="button" wire:click="$set('quantity', {{ $quantity }} + 1)" class="px-3.5 py-3 text-pink-500 hover:bg-pink-100 transition font-bold">+</button>
        </div>
        <button wire:click="add" wire:loading.attr="disabled"
                class="flex-1 sm:flex-none bg-pink-500 hover:bg-pink-600 text-white font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
            <svg wire:loading.remove wire:target="add" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
            <span wire:loading.remove wire:target="add">Añadir al carrito</span>
            <svg wire:loading wire:target="add" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
            <span wire:loading wire:target="add">Añadiendo...</span>
        </button>
    @endif
</div>
