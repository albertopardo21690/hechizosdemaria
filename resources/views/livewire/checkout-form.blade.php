<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-2">Checkout</p>
        <h1 class="font-heading text-4xl md:text-5xl text-pink-700">Finalizar compra</h1>
    </div>

    @if(session('checkout_error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm">{{ session('checkout_error') }}</div>
    @endif

    @if(!$lines->count())
        <div class="bg-white border border-pink-100 rounded-2xl p-12 text-center shadow-sm">
            <p class="text-gray-500 mb-6">No tienes productos en el carrito.</p>
            <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-bold tracking-widest uppercase text-sm bg-pink-500 hover:bg-pink-600 text-white transition">Ir a la tienda</a>
        </div>
    @else
        <form wire:submit="placeOrder" class="grid lg:grid-cols-[1fr_380px] gap-8">

            <div class="space-y-6">
                {{-- Contacto --}}
                <section class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm">
                    <h2 class="font-heading text-lg text-pink-700 mb-4">Contacto</h2>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Email *</label>
                        <input type="email" wire:model="email" required class="w-full border border-pink-200 rounded-xl px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </section>

                {{-- Dirección --}}
                <section class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm">
                    <h2 class="font-heading text-lg text-pink-700 mb-4">Dirección de envío</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Nombre *</label>
                            <input type="text" wire:model="firstName" required class="w-full border border-pink-200 rounded-xl px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            @error('firstName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Apellidos *</label>
                            <input type="text" wire:model="lastName" required class="w-full border border-pink-200 rounded-xl px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            @error('lastName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Teléfono</label>
                            <input type="tel" wire:model="phone" class="w-full border border-pink-200 rounded-xl px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Dirección *</label>
                            <input type="text" wire:model="line1" required placeholder="Calle y número" class="w-full border border-pink-200 rounded-xl px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            @error('line1') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Piso / puerta</label>
                            <input type="text" wire:model="line2" class="w-full border border-pink-200 rounded-xl px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Ciudad *</label>
                            <input type="text" wire:model="city" required class="w-full border border-pink-200 rounded-xl px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Provincia</label>
                            <input type="text" wire:model="state" class="w-full border border-pink-200 rounded-xl px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">Código postal *</label>
                            <input type="text" wire:model="postcode" required class="w-full border border-pink-200 rounded-xl px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100">
                            @error('postcode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-1">País *</label>
                            <select wire:model="countryId" required class="w-full border border-pink-200 rounded-xl px-4 py-3 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100 bg-white">
                                @foreach($countries as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </section>

                {{-- Método de pago --}}
                <section class="bg-white border border-pink-100 rounded-2xl p-6 shadow-sm">
                    <h2 class="font-heading text-lg text-pink-700 mb-4">Método de pago</h2>
                    <div class="space-y-3">
                        <label class="flex items-center gap-4 p-4 bg-pink-50/50 border border-pink-100 rounded-xl cursor-pointer hover:border-pink-400 has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50 transition">
                            <input type="radio" wire:model="paymentMethod" value="stripe" class="accent-pink-500 w-4 h-4">
                            <div>
                                <div class="font-semibold text-sm text-gray-800">Tarjeta / Apple Pay / Google Pay</div>
                                <div class="text-xs text-gray-500">Procesado seguro vía Stripe</div>
                            </div>
                        </label>
                        <label class="flex items-center gap-4 p-4 bg-pink-50/50 border border-pink-100 rounded-xl cursor-pointer hover:border-pink-400 has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50 transition">
                            <input type="radio" wire:model="paymentMethod" value="paypal" class="accent-pink-500 w-4 h-4">
                            <div>
                                <div class="font-semibold text-sm text-gray-800">PayPal</div>
                                <div class="text-xs text-gray-500">Paga con tu cuenta PayPal</div>
                            </div>
                        </label>
                        <label class="flex items-center gap-4 p-4 bg-pink-50/50 border border-pink-100 rounded-xl cursor-pointer hover:border-pink-400 has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50 transition">
                            <input type="radio" wire:model="paymentMethod" value="redsys" class="accent-pink-500 w-4 h-4">
                            <div>
                                <div class="font-semibold text-sm text-gray-800">Tarjeta (Redsys)</div>
                                <div class="text-xs text-gray-500">TPV bancario español</div>
                            </div>
                        </label>
                        <label class="flex items-center gap-4 p-4 bg-pink-50/50 border border-pink-100 rounded-xl cursor-pointer hover:border-pink-400 has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50 transition">
                            <input type="radio" wire:model="paymentMethod" value="bizum" class="accent-pink-500 w-4 h-4">
                            <div>
                                <div class="font-semibold text-sm text-gray-800">Bizum</div>
                                <div class="text-xs text-gray-500">Pago directo al móvil de María José</div>
                            </div>
                        </label>
                    </div>
                </section>
            </div>

            {{-- Sidebar resumen --}}
            <aside class="bg-white border border-pink-100 rounded-2xl p-6 h-fit lg:sticky lg:top-24 shadow-sm">
                <h2 class="font-heading text-lg text-pink-700 mb-5">Tu pedido</h2>
                <div class="space-y-3 mb-5 border-b border-pink-100 pb-4">
                    @foreach($lines as $line)
                        @php
                            $lineSub = $line->subTotal?->decimal ?? (($line->unitPrice?->decimal ?? 0) * $line->quantity);
                        @endphp
                        <div class="flex justify-between text-sm gap-2">
                            <span class="text-gray-600 min-w-0">
                                {{ $line->purchasable?->product?->attribute_data['name']?->getValue() ?? $line->description }}
                                <span class="text-gray-400 text-xs">x{{ $line->quantity }}</span>
                            </span>
                            <span class="text-gray-800 font-semibold whitespace-nowrap">{{ number_format($lineSub, 2, ',', '.') }} €</span>
                        </div>
                    @endforeach
                </div>
                <dl class="space-y-2 text-sm pb-4 border-b border-pink-100 mb-4">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Subtotal</dt>
                        <dd class="text-gray-700 font-semibold">{{ number_format($cart->subTotal->decimal ?? 0, 2, ',', '.') }} €</dd>
                    </div>
                </dl>
                <div class="flex justify-between items-baseline mb-6">
                    <span class="font-heading text-lg text-gray-800">Total</span>
                    <span class="text-2xl font-bold text-pink-600">{{ number_format($cart->total->decimal ?? 0, 2, ',', '.') }} €</span>
                </div>
                <button type="submit" wire:loading.attr="disabled"
                        class="w-full bg-pink-500 hover:bg-pink-600 disabled:bg-pink-300 text-white font-bold uppercase tracking-widest text-sm py-4 rounded-xl transition shadow-lg shadow-pink-500/20 flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="placeOrder">Pagar {{ number_format($cart->total->decimal ?? 0, 2, ',', '.') }} €</span>
                    <svg wire:loading wire:target="placeOrder" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <span wire:loading wire:target="placeOrder">Procesando...</span>
                </button>
                <div class="flex items-center justify-center gap-2 mt-4 text-xs text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    Pago seguro encriptado
                </div>
            </aside>
        </form>
    @endif
</div>
