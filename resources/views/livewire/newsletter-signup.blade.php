<div>
    @if($success)
        <div class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-xl p-4 text-center">
            <p class="text-sm text-white font-semibold">¡Suscrito! Recibirás novedades y ofertas.</p>
        </div>
    @else
        <form wire:submit="subscribe" class="flex flex-col sm:flex-row gap-3">
            <input type="email" wire:model="email" placeholder="Tu correo electrónico" required
                   class="flex-1 px-5 py-3.5 bg-white/15 border border-white/25 rounded-xl text-white placeholder:text-white/60 focus:border-white/50 focus:outline-none backdrop-blur-sm text-sm">
            <button type="submit" wire:loading.attr="disabled"
                    class="bg-white text-pink-600 font-bold text-xs uppercase tracking-widest px-6 py-3.5 rounded-xl hover:bg-pink-50 transition shadow-lg shrink-0">
                <span wire:loading.remove>Suscribirse</span>
                <span wire:loading>Enviando...</span>
            </button>
        </form>
        @if($error)
            <p class="text-xs text-pink-200 mt-2">{{ $error }}</p>
        @endif
        @error('email')<p class="text-xs text-pink-200 mt-2">{{ $message }}</p>@enderror
    @endif
</div>
