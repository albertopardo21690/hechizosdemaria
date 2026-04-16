<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <p class="text-gold-400 text-xs tracking-[0.4em] uppercase mb-2">Checkout</p>
        <h1 class="font-heading text-4xl md:text-5xl text-shimmer">Finalizar compra</h1>
    </div>

    @if(session('checkout_error'))
        <div class="mb-6 bg-red-900/40 border border-red-500/40 text-red-300 rounded-lg p-4">{{ session('checkout_error') }}</div>
    @endif

    @if(!$lines->count())
        <div class="bg-mystic-800/50 border border-gold-500/10 rounded-2xl p-12 text-center">
            <p class="text-gray-400 mb-6">No tienes productos en el carrito.</p>
            <a href="{{ route('shop') }}" class="btn-mystic">Ir a la tienda</a>
        </div>
    @else
        <form wire:submit="placeOrder" class="grid lg:grid-cols-[1fr_380px] gap-8">

            <div class="space-y-8">
                <section class="bg-mystic-800/50 border border-gold-500/10 rounded-2xl p-6">
                    <h2 class="font-heading text-xl text-gold-400 mb-5">Contacto</h2>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-400 mb-1">Email *</label>
                        <input type="email" wire:model="email" required class="w-full bg-mystic-950/60 border border-gold-500/20 rounded-md px-4 py-3 text-white focus:border-gold-400 focus:outline-none">
                        @error('email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                </section>

                <section class="bg-mystic-800/50 border border-gold-500/10 rounded-2xl p-6">
                    <h2 class="font-heading text-xl text-gold-400 mb-5">Direccion de envio</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-400 mb-1">Nombre *</label>
                            <input type="text" wire:model="firstName" required class="w-full bg-mystic-950/60 border border-gold-500/20 rounded-md px-4 py-3 text-white focus:border-gold-400 focus:outline-none">
                            @error('firstName') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-400 mb-1">Apellidos *</label>
                            <input type="text" wire:model="lastName" required class="w-full bg-mystic-950/60 border border-gold-500/20 rounded-md px-4 py-3 text-white focus:border-gold-400 focus:outline-none">
                            @error('lastName') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs uppercase tracking-widest text-gray-400 mb-1">Telefono</label>
                            <input type="tel" wire:model="phone" class="w-full bg-mystic-950/60 border border-gold-500/20 rounded-md px-4 py-3 text-white focus:border-gold-400 focus:outline-none">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs uppercase tracking-widest text-gray-400 mb-1">Direccion *</label>
                            <input type="text" wire:model="line1" required placeholder="Calle y numero" class="w-full bg-mystic-950/60 border border-gold-500/20 rounded-md px-4 py-3 text-white focus:border-gold-400 focus:outline-none">
                            @error('line1') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs uppercase tracking-widest text-gray-400 mb-1">Piso / puerta</label>
                            <input type="text" wire:model="line2" class="w-full bg-mystic-950/60 border border-gold-500/20 rounded-md px-4 py-3 text-white focus:border-gold-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-400 mb-1">Ciudad *</label>
                            <input type="text" wire:model="city" required class="w-full bg-mystic-950/60 border border-gold-500/20 rounded-md px-4 py-3 text-white focus:border-gold-400 focus:outline-none">
                            @error('city') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-400 mb-1">Provincia</label>
                            <input type="text" wire:model="state" class="w-full bg-mystic-950/60 border border-gold-500/20 rounded-md px-4 py-3 text-white focus:border-gold-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-400 mb-1">Codigo postal *</label>
                            <input type="text" wire:model="postcode" required class="w-full bg-mystic-950/60 border border-gold-500/20 rounded-md px-4 py-3 text-white focus:border-gold-400 focus:outline-none">
                            @error('postcode') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-400 mb-1">Pais *</label>
                            <select wire:model="countryId" required class="w-full bg-mystic-950/60 border border-gold-500/20 rounded-md px-4 py-3 text-white focus:border-gold-400 focus:outline-none">
                                @foreach($countries as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </section>

                <section class="bg-mystic-800/50 border border-gold-500/10 rounded-2xl p-6">
                    <h2 class="font-heading text-xl text-gold-400 mb-5">Metodo de pago</h2>
                    <div class="space-y-3">
                        <label class="flex items-center gap-4 p-4 bg-mystic-950/60 border border-gold-500/20 rounded-md cursor-pointer hover:border-gold-400 transition">
                            <input type="radio" wire:model="paymentMethod" value="stripe" class="accent-gold-400">
                            <div>
                                <div class="font-semibold">Tarjeta / Apple Pay / Google Pay</div>
                                <div class="text-xs text-gray-400">Procesado seguro via Stripe</div>
                            </div>
                        </label>
                        <label class="flex items-center gap-4 p-4 bg-mystic-950/60 border border-gold-500/20 rounded-md cursor-pointer hover:border-gold-400 transition">
                            <input type="radio" wire:model="paymentMethod" value="paypal" class="accent-gold-400">
                            <div>
                                <div class="font-semibold">PayPal</div>
                                <div class="text-xs text-gray-400">Paga con tu cuenta PayPal</div>
                            </div>
                        </label>
                        <label class="flex items-center gap-4 p-4 bg-mystic-950/60 border border-gold-500/20 rounded-md cursor-pointer hover:border-gold-400 transition">
                            <input type="radio" wire:model="paymentMethod" value="redsys" class="accent-gold-400">
                            <div>
                                <div class="font-semibold">Bizum / Tarjeta (Redsys)</div>
                                <div class="text-xs text-gray-400">TPV bancario espanol, acepta Bizum</div>
                            </div>
                        </label>
                    </div>
                </section>
            </div>

            <aside class="bg-mystic-800/50 border border-gold-500/10 rounded-2xl p-6 h-fit lg:sticky lg:top-24">
                <h2 class="font-heading text-xl text-gold-400 mb-5">Tu pedido</h2>
                <div class="space-y-3 mb-5 border-b border-white/10 pb-4">
                    @foreach($lines as $line)
                        @php
                            $lineSub = $line->subTotal?->decimal ?? (($line->unitPrice?->decimal ?? 0) * $line->quantity);
                        @endphp
                        <div class="flex justify-between text-sm gap-2">
                            <span class="text-gray-300">
                                {{ $line->purchasable?->product?->attribute_data['name']?->getValue() ?? $line->description }}
                                <span class="text-gray-500">x{{ $line->quantity }}</span>
                            </span>
                            <span class="text-gold-400 whitespace-nowrap">{{ number_format($lineSub, 2, ',', '.') }} €</span>
                        </div>
                    @endforeach
                </div>
                <dl class="space-y-2 text-sm pb-4 border-b border-white/10 mb-4">
                    <div class="flex justify-between">
                        <dt class="text-gray-400">Subtotal</dt>
                        <dd>{{ number_format($cart->subTotal->decimal ?? 0, 2, ',', '.') }} €</dd>
                    </div>
                </dl>
                <div class="flex justify-between items-baseline mb-6">
                    <span class="font-heading text-lg">Total</span>
                    <span class="text-2xl font-bold text-gold-400">{{ number_format($cart->total->decimal ?? 0, 2, ',', '.') }} €</span>
                </div>
                <button type="submit" wire:loading.attr="disabled" class="btn-mystic w-full">
                    <span wire:loading.remove wire:target="placeOrder">Pagar {{ number_format($cart->total->decimal ?? 0, 2, ',', '.') }} €</span>
                    <span wire:loading wire:target="placeOrder">Procesando...</span>
                </button>
                <p class="text-[10px] text-gold-400/60 text-center mt-4 uppercase tracking-widest">Pago seguro encriptado</p>
            </aside>
        </form>
    @endif
</div>
