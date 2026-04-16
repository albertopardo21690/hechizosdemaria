<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Carrito</p>
        <h1 class="font-heading text-4xl md:text-5xl text-shimmer">Tu carrito magico</h1>
    </div>

    @if(!$lines->count())
        <div class="bg-mystic-800/50 border border-gold-500/10 rounded-2xl p-12 text-center">
            <svg class="w-20 h-20 mx-auto text-gold-400/40 mb-6" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272"/>
            </svg>
            <p class="text-gray-400 mb-6">Aun no has anadido nada.</p>
            <a href="{{ route('shop') }}" class="btn-mystic">Explorar la tienda</a>
        </div>
    @else
        <div class="grid lg:grid-cols-[1fr_380px] gap-8">
            <div class="space-y-4">
                @foreach($lines as $line)
                    @php
                        $variant = $line->purchasable;
                        $product = $variant?->product;
                        $name = $product?->attribute_data['name']?->getValue() ?? $line->description;
                        $image = $product?->getFirstMedia('images');
                    @endphp
                    <div class="flex gap-4 bg-mystic-800/50 border border-gold-500/10 rounded-xl p-4" wire:key="line-{{ $line->id }}">
                        <div class="w-24 h-24 bg-mystic-950 rounded-lg overflow-hidden flex-shrink-0">
                            @if($image)
                                <img src="{{ $image->getUrl('small') }}" alt="{{ $name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gold-400/40">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-heading text-lg">{{ $name }}</h3>
                            <p class="text-xs text-gray-500 mb-3">SKU: {{ $variant?->sku }}</p>
                            <div class="flex items-center gap-3 flex-wrap">
                                <div class="flex items-center bg-mystic-950/60 border border-gold-500/20 rounded-md text-sm">
                                    <button wire:click="updateQuantity({{ $line->id }}, {{ $line->quantity - 1 }})" class="px-3 py-2 text-gold-400 hover:text-gold-300">&minus;</button>
                                    <span class="px-3 w-10 text-center">{{ $line->quantity }}</span>
                                    <button wire:click="updateQuantity({{ $line->id }}, {{ $line->quantity + 1 }})" class="px-3 py-2 text-gold-400 hover:text-gold-300">+</button>
                                </div>
                                <button wire:click="remove({{ $line->id }})" class="text-gray-500 hover:text-red-400 text-sm">Eliminar</button>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-gold-400 font-bold">
                                {{ number_format($line->subTotal->decimal ?? 0, 2, ',', '.') }} €
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <aside class="bg-mystic-800/50 border border-gold-500/10 rounded-2xl p-6 h-fit lg:sticky lg:top-24">
                <h2 class="font-heading text-xl mb-5 text-gold-400">Resumen</h2>
                <dl class="space-y-2 text-sm border-b border-white/10 pb-4 mb-4">
                    <div class="flex justify-between">
                        <dt class="text-gray-400">Subtotal</dt>
                        <dd>{{ number_format($cart->subTotal->decimal ?? 0, 2, ',', '.') }} €</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-400">Envio</dt>
                        <dd class="text-gold-400/80 text-xs uppercase tracking-widest">Calculado en checkout</dd>
                    </div>
                </dl>
                <div class="flex justify-between items-baseline mb-6">
                    <span class="font-heading text-lg">Total</span>
                    <span class="text-2xl font-bold text-gold-400">{{ number_format($cart->total->decimal ?? 0, 2, ',', '.') }} €</span>
                </div>
                <a href="{{ route('checkout') }}" class="btn-mystic w-full">Finalizar compra</a>
                <a href="{{ route('shop') }}" class="block text-center mt-3 text-gold-400/80 hover:text-gold-300 text-sm">Seguir comprando</a>
                <p class="text-xs text-gold-400/60 text-center mt-6 uppercase tracking-widest">Envio gratis desde 50€</p>
            </aside>
        </div>
    @endif
</div>
