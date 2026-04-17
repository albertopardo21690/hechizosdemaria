<div>
    @if($success)
        <div class="bg-green-50 border border-green-200 rounded-md p-4 text-center">
            <p class="text-sm text-green-700 font-semibold">¡Suscrito! Recibirás novedades y ofertas.</p>
        </div>
    @else
        <form wire:submit="subscribe" class="flex gap-2">
            <input type="email" wire:model="email" placeholder="Tu email" required class="flex-1 border border-pink-200 rounded-md px-3 py-2 text-sm focus:border-pink-500 focus:outline-none">
            <button type="submit" wire:loading.attr="disabled" class="bg-pink-500 hover:bg-pink-600 text-white text-xs uppercase tracking-widest font-semibold px-4 py-2 rounded-md shrink-0">
                <span wire:loading.remove>Suscribir</span>
                <span wire:loading>...</span>
            </button>
        </form>
        @if($error)
            <p class="text-xs text-red-600 mt-1">{{ $error }}</p>
        @endif
        @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    @endif
</div>
