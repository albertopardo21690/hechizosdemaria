<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-2">Carrito</p>
        <h1 class="font-heading text-4xl md:text-5xl text-pink-700">Tu carrito mágico</h1>
    </div>

    @if(!$lines->count())
        <div class="bg-white border border-pink-100 rounded-2xl p-12 text-center shadow-sm">
            <div class="mx-auto w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-pink-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                </svg>
            </div>
            <p class="text-gray-500 mb-6">Aún no has añadido nada.</p>
            <a href="{{ route('shop') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-bold tracking-widest uppercase text-sm bg-pink-500 hover:bg-pink-600 text-white transition">Explorar la tienda</a>
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
                    <div class="flex gap-4 bg-white border border-pink-100 rounded-2xl p-4 hover:shadow-md transition-shadow" wire:key="line-{{ $line->id }}">
                        <div class="w-24 h-24 bg-pink-50 rounded-xl overflow-hidden flex-shrink-0">
                            @if($image)
                                <img src="{{ $image->getUrl('small') }}" alt="{{ $name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-pink-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-heading text-base text-gray-800">{{ $name }}</h3>
                            @if($variant?->sku)<p class="text-[10px] text-gray-400 mb-2">{{ $variant->sku }}</p>@endif
                            <div class="flex items-center gap-3 flex-wrap">
                                <div class="flex items-center bg-pink-50 border border-pink-200 rounded-lg text-sm">
                                    <button wire:click="updateQuantity({{ $line->id }}, {{ $line->quantity - 1 }})" class="px-3 py-1.5 text-pink-500 hover:bg-pink-100 rounded-l-lg transition">&minus;</button>
                                    <span class="px-3 w-10 text-center font-semibold text-gray-800">{{ $line->quantity }}</span>
                                    <button wire:click="updateQuantity({{ $line->id }}, {{ $line->quantity + 1 }})" class="px-3 py-1.5 text-pink-500 hover:bg-pink-100 rounded-r-lg transition">+</button>
                                </div>
                                <button wire:click="remove({{ $line->id }})" class="text-gray-400 hover:text-red-500 text-xs font-semibold transition">Eliminar</button>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-pink-600 font-bold text-lg">
                                {{ number_format(($line->subTotal?->decimal ?? $line->unitPrice?->decimal * $line->quantity) ?? 0, 2, ',', '.') }} €
                            </p>
                            @if(($line->unitPrice?->decimal ?? 0) > 0 && $line->quantity > 1)
                                <p class="text-xs text-gray-400 mt-1">{{ number_format($line->unitPrice->decimal, 2, ',', '.') }} € / ud</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @php
                $sub = $cart->subTotal?->decimal ?? 0;
                $tax = $cart->taxTotal?->decimal ?? 0;
                $total = $cart->total?->decimal ?? 0;
                $freeShipping = $sub >= 50;
                $shipping = $freeShipping ? 0 : 4.90;
            @endphp
            <aside class="bg-white border border-pink-100 rounded-2xl p-6 h-fit lg:sticky lg:top-24 shadow-sm">
                <h2 class="font-heading text-xl mb-5 text-pink-700">Resumen</h2>
                <dl class="space-y-3 text-sm border-b border-pink-100 pb-4 mb-4">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Subtotal</dt>
                        <dd class="font-semibold text-gray-700">{{ number_format($sub, 2, ',', '.') }} €</dd>
                    </div>
                    @if($tax > 0)
                    <div class="flex justify-between">
                        <dt class="text-gray-500">IVA (21%)</dt>
                        <dd class="text-gray-700">{{ number_format($tax, 2, ',', '.') }} €</dd>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Envío</dt>
                        <dd>
                            @if($freeShipping)
                                <span class="text-green-600 font-semibold">Gratis</span>
                            @else
                                {{ number_format($shipping, 2, ',', '.') }} €
                            @endif
                        </dd>
                    </div>
                </dl>

                <div class="flex justify-between items-baseline mb-6">
                    <span class="font-heading text-lg text-gray-800">Total</span>
                    <span class="text-2xl font-bold text-pink-600">{{ number_format($total + $shipping, 2, ',', '.') }} €</span>
                </div>

                {{-- Cupón --}}
                <div class="mb-4">
                    @if($couponMessage)
                        <div class="p-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center justify-between">
                            <span>{{ $couponMessage }} (-{{ number_format($couponDiscount, 2, ',', '.') }} €)</span>
                            <button type="button" wire:click="removeCoupon" class="text-red-500 text-xs font-bold hover:text-red-700">Quitar</button>
                        </div>
                    @else
                        <div class="flex gap-2">
                            <input type="text" wire:model.live="couponCode" placeholder="Código cupón" class="flex-1 border border-pink-200 rounded-lg px-3 py-2 text-sm focus:border-pink-400 focus:outline-none">
                            <button type="button" wire:click="applyCoupon" class="bg-pink-100 hover:bg-pink-200 text-pink-700 text-xs uppercase tracking-widest font-bold px-4 py-2 rounded-lg transition">Aplicar</button>
                        </div>
                        @if($couponError)
                            <p class="text-xs text-red-500 mt-1">{{ $couponError }}</p>
                        @endif
                    @endif
                </div>

                @if(!$freeShipping)
                    <div class="mb-4 p-3 bg-pink-50 border border-pink-200 rounded-xl text-xs text-pink-600 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                        Añade {{ number_format(50 - $sub, 2, ',', '.') }} € más para envío gratis
                    </div>
                @endif

                <a href="{{ route('checkout') }}" class="block w-full text-center bg-pink-500 hover:bg-pink-600 text-white font-bold uppercase tracking-widest text-sm py-4 rounded-xl transition shadow-lg shadow-pink-500/20">Finalizar compra</a>
                <a href="{{ route('shop') }}" class="block text-center mt-3 text-pink-500 hover:text-pink-700 text-sm font-semibold">← Seguir comprando</a>
                <div class="flex items-center justify-center gap-2 mt-6 text-xs text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    Pago 100% seguro
                </div>
            </aside>
        </div>
    @endif
</div>
