<div class="flex items-center gap-3">
    @if($added)
        <div class="flex items-center gap-2 text-green-400 font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Anadido al carrito
        </div>
        <a href="{{ route('cart') }}" class="text-gold-400 hover:text-pink-700 text-sm uppercase tracking-widest underline">Ver carrito</a>
    @else
        <div class="flex items-center bg-mystic-950/60 border border-gold-500/20 rounded-md">
            <button type="button" wire:click="$set('quantity', Math.max(1, {{ $quantity }} - 1))" class="px-3 py-3 text-gold-400 hover:text-pink-700">&minus;</button>
            <input type="number" min="1" wire:model="quantity" class="w-12 bg-transparent text-center text-gray-900 outline-none py-3">
            <button type="button" wire:click="$set('quantity', {{ $quantity }} + 1)" class="px-3 py-3 text-gold-400 hover:text-pink-700">+</button>
        </div>
        <button wire:click="add" wire:loading.attr="disabled" class="btn-mystic">
            <span wire:loading.remove wire:target="add">Anadir al carrito</span>
            <span wire:loading wire:target="add">Anadiendo...</span>
        </button>
    @endif
</div>
