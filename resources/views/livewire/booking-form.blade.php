<div class="max-w-3xl mx-auto">
    {{-- PROGRESS --}}
    @if($step !== 'success')
        <div class="flex items-center justify-center gap-3 mb-10">
            @foreach([1 => 'Servicio', 2 => 'Fecha y datos', 3 => 'Confirmación'] as $n => $label)
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $step >= $n ? 'bg-pink-500 text-white' : 'bg-pink-100 text-pink-400' }}">{{ $n }}</div>
                    <span class="text-xs uppercase tracking-widest {{ $step >= $n ? 'text-pink-700' : 'text-gray-400' }} hidden sm:inline">{{ $label }}</span>
                </div>
                @if($n < 3)<div class="w-8 h-px {{ $step > $n ? 'bg-pink-400' : 'bg-pink-200' }}"></div>@endif
            @endforeach
        </div>
    @endif

    {{-- STEP 1: Servicio --}}
    @if($step === 1)
        <h2 class="font-heading text-2xl text-pink-700 text-center mb-6">Elige tu servicio</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach($services as $s)
                <button type="button" wire:click="selectService({{ $s->id }})" class="group text-left bg-white border-2 border-pink-200 hover:border-pink-500 rounded-xl p-5 transition">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-heading text-pink-700 group-hover:text-pink-600">{{ $s->name }}</h3>
                        <span class="text-lg font-bold text-pink-600">{{ number_format($s->price, 2, ',', '.') }}€</span>
                    </div>
                    @if($s->short_description)
                        <p class="text-sm text-gray-600 mb-2">{{ $s->short_description }}</p>
                    @endif
                    <div class="flex gap-2 text-[10px] uppercase tracking-widest text-gray-500">
                        <span class="bg-pink-50 px-2 py-0.5 rounded">{{ \App\Models\BookingService::categories()[$s->category] ?? $s->category }}</span>
                        <span class="bg-pink-50 px-2 py-0.5 rounded">{{ \App\Models\BookingService::deliveryMethods()[$s->delivery_method] ?? $s->delivery_method }}</span>
                    </div>
                </button>
            @endforeach
        </div>
        @if($services->isEmpty())
            <div class="text-center py-12 text-gray-500">No hay servicios disponibles en este momento.</div>
        @endif
    @endif

    {{-- STEP 2: Fecha + datos --}}
    @if($step === 2 && $selectedService)
        <div class="bg-white border border-pink-200 rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-heading text-xl text-pink-700">{{ $selectedService->name }}</h2>
                    <p class="text-sm text-gray-600">{{ number_format($selectedService->price, 2, ',', '.') }} €</p>
                </div>
                <button type="button" wire:click="goToStep(1)" class="text-xs text-pink-600 hover:text-pink-800 uppercase tracking-widest font-semibold">← Cambiar</button>
            </div>

            <div class="space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre completo *</label>
                        <input type="text" wire:model="name" required class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                        @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email *</label>
                        <input type="email" wire:model="email" required class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                        @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                        <input type="tel" wire:model="phone" class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Método de contacto</label>
                        <select wire:model="deliveryMethod" class="w-full border border-pink-200 rounded-md px-3 py-2">
                            @foreach(\App\Models\BookingService::deliveryMethods() as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha preferida (opcional)</label>
                        <input type="date" wire:model="preferredDate" min="{{ now()->format('Y-m-d') }}" class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                        <p class="text-xs text-gray-400 mt-1">Deja vacío si eres flexible</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Hora preferida (opcional)</label>
                        <select wire:model="preferredTime" class="w-full border border-pink-200 rounded-md px-3 py-2">
                            <option value="">Flexible</option>
                            <option value="mañana">Mañana (9-13h)</option>
                            <option value="tarde">Tarde (15-20h)</option>
                            <option value="noche">Noche (20-23h)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">¿Algo que quieras contarle a María José?</label>
                    <textarea wire:model="notes" rows="3" placeholder="Tu situación, preguntas concretas..." class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Cupón (opcional)</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model="couponCode" placeholder="Código" class="flex-1 border border-pink-200 rounded-md px-3 py-2 text-sm focus:border-pink-500 focus:outline-none">
                        <button type="button" wire:click="applyCoupon" class="bg-pink-100 hover:bg-pink-200 text-pink-700 text-xs uppercase tracking-widest font-semibold px-4 py-2 rounded-md">Aplicar</button>
                    </div>
                    @if($couponMessage)<p class="text-xs text-green-600 mt-1">{{ $couponMessage }}</p>@endif
                    @if($couponError)<p class="text-xs text-red-600 mt-1">{{ $couponError }}</p>@endif
                </div>
            </div>

            <div class="flex justify-between items-center mt-6 pt-6 border-t border-pink-200">
                <div>
                    <span class="text-gray-600">Total:</span>
                    @if($discount > 0)
                        <span class="text-gray-400 line-through text-sm ml-1">{{ number_format($selectedService->price, 2, ',', '.') }}€</span>
                    @endif
                    <span class="text-xl font-bold text-pink-700 ml-1">{{ number_format(max(0, $selectedService->price - $discount), 2, ',', '.') }}€</span>
                </div>
                <button type="button" wire:click="goToStep(3)" class="bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 text-white font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-md">Continuar</button>
            </div>
        </div>
    @endif

    {{-- STEP 3: Confirmación --}}
    @if($step === 3 && $selectedService)
        <div class="bg-white border border-pink-200 rounded-xl p-6">
            <h2 class="font-heading text-xl text-pink-700 mb-6">Confirma tu reserva</h2>
            <dl class="divide-y divide-pink-100 text-sm mb-6">
                <div class="flex justify-between py-3"><dt class="text-gray-600">Servicio</dt><dd class="font-semibold">{{ $selectedService->name }}</dd></div>
                <div class="flex justify-between py-3"><dt class="text-gray-600">Nombre</dt><dd>{{ $name }}</dd></div>
                <div class="flex justify-between py-3"><dt class="text-gray-600">Email</dt><dd>{{ $email }}</dd></div>
                @if($phone)<div class="flex justify-between py-3"><dt class="text-gray-600">Teléfono</dt><dd>{{ $phone }}</dd></div>@endif
                <div class="flex justify-between py-3"><dt class="text-gray-600">Fecha</dt><dd>{{ $preferredDate ? \Carbon\Carbon::parse($preferredDate)->format('d/m/Y') : 'Flexible' }} {{ $preferredTime }}</dd></div>
                <div class="flex justify-between py-3"><dt class="text-gray-600">Método</dt><dd>{{ \App\Models\BookingService::deliveryMethods()[$deliveryMethod] ?? $deliveryMethod }}</dd></div>
                <div class="flex justify-between py-3 text-lg font-bold text-pink-700"><dt>Total</dt><dd>{{ number_format(max(0, $selectedService->price - $discount), 2, ',', '.') }}€</dd></div>
            </dl>

            <p class="text-sm text-gray-600 mb-4">Al confirmar, María José recibirá tu solicitud y se pondrá en contacto contigo. Puedes elegir:</p>

            <div class="grid sm:grid-cols-2 gap-3">
                <button type="button" wire:click="submitBooking" class="bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 text-white font-bold uppercase tracking-widest text-sm py-4 rounded-xl transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Confirmar reserva
                </button>
                <a href="{{ 'https://api.whatsapp.com/send?phone=34695619087&text='.rawurlencode("Hola, quiero reservar *{$selectedService->name}*. Soy {$name}.") }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white font-bold uppercase tracking-widest text-sm py-4 rounded-xl transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.82 11.82 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/></svg>
                    Reservar por WhatsApp
                </a>
            </div>

            <button type="button" wire:click="goToStep(2)" class="block text-center text-xs text-pink-600 hover:text-pink-800 uppercase tracking-widest font-semibold mt-4 mx-auto">← Modificar datos</button>
        </div>
    @endif

    {{-- SUCCESS --}}
    @if($step === 'success' && $createdBooking)
        <div class="text-center">
            <div class="mx-auto w-20 h-20 rounded-full bg-green-100 border border-green-300 flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h2 class="font-heading text-3xl text-pink-700 mb-3">¡Reserva enviada!</h2>
            <p class="text-gray-600 mb-2">Referencia: <span class="font-mono font-bold text-pink-700">#{{ $createdBooking->reference }}</span></p>
            <p class="text-sm text-gray-500 mb-6">María José revisará tu solicitud y te contactará pronto.</p>

            <div class="bg-green-50 border border-green-200 rounded-xl p-5 max-w-md mx-auto mb-6">
                <p class="text-sm text-green-700 mb-3">¿Quieres adelantar y escribirle directamente?</p>
                <a href="{{ $createdBooking->whatsappUrl() }}" target="_blank" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold text-sm px-6 py-3 rounded-lg transition">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.82 11.82 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/></svg>
                    WhatsApp con María José
                </a>
            </div>

            <a href="{{ route('home') }}" class="text-pink-600 hover:text-pink-800 text-sm font-semibold uppercase tracking-widest">← Volver al inicio</a>
        </div>
    @endif
</div>
