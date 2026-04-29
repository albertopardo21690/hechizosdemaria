<div>
    {{-- Header --}}
    <div class="text-center mb-10">
        <p class="text-pink-400 text-xs tracking-[0.4em] uppercase mb-2">Todo lo que necesitas</p>
        <h1 class="font-heading text-4xl md:text-5xl text-pink-700">Tienda Mágica</h1>
    </div>

    <div class="grid lg:grid-cols-[280px_1fr] gap-8">
        {{-- Sidebar Filters --}}
        <aside class="space-y-6">
            {{-- Search --}}
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-2">Buscar</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="¿Qué buscas?"
                           class="w-full border border-pink-200 rounded-xl px-4 py-2.5 pr-10 text-sm focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-100 transition">
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-pink-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                </div>
            </div>

            {{-- Collections --}}
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-2">Categorías</label>
                <div class="space-y-1">
                    <button wire:click="$set('collection', '')"
                            class="block w-full text-left px-3 py-2 rounded-lg text-sm transition {{ !$collection ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-600 hover:bg-pink-50' }}">
                        Todas
                    </button>
                    @foreach($collections as $c)
                        <button wire:click="$set('collection', '{{ $c->slug }}')"
                                class="block w-full text-left px-3 py-2 rounded-lg text-sm transition {{ $collection === $c->slug ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-600 hover:bg-pink-50' }}">
                            {{ $c->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Price range --}}
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-500 font-semibold mb-2">Precio</label>
                <div class="flex gap-2">
                    <input type="number" wire:model.live.debounce.500ms="priceMin" placeholder="Min €" min="0" step="1"
                           class="w-full border border-pink-200 rounded-lg px-3 py-2 text-sm focus:border-pink-400 focus:outline-none">
                    <span class="text-gray-400 self-center">—</span>
                    <input type="number" wire:model.live.debounce.500ms="priceMax" placeholder="Max €" min="0" step="1"
                           class="w-full border border-pink-200 rounded-lg px-3 py-2 text-sm focus:border-pink-400 focus:outline-none">
                </div>
            </div>

            {{-- Clear filters --}}
            @if($hasFilters)
                <button wire:click="clearFilters" class="text-xs text-pink-500 hover:text-pink-700 uppercase tracking-widest font-semibold flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    Limpiar filtros
                </button>
            @endif
        </aside>

        {{-- Products grid --}}
        <div>
            {{-- Toolbar --}}
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <p class="text-sm text-gray-500">
                    <span class="font-semibold text-gray-700">{{ $products->total() }}</span> productos
                    @if($search) para "<span class="text-pink-600 font-semibold">{{ $search }}</span>"@endif
                </p>
                <div class="flex items-center gap-2">
                    <label class="text-xs text-gray-500 uppercase tracking-widest">Ordenar:</label>
                    <select wire:model.live="sort" class="border border-pink-200 rounded-lg px-3 py-2 text-sm focus:border-pink-400 focus:outline-none bg-white">
                        <option value="newest">Más recientes</option>
                        <option value="price_asc">Precio: menor a mayor</option>
                        <option value="price_desc">Precio: mayor a menor</option>
                        <option value="name_asc">Nombre: A-Z</option>
                        <option value="name_desc">Nombre: Z-A</option>
                    </select>
                </div>
            </div>

            {{-- Loading overlay --}}
            <div wire:loading.delay class="text-center py-8">
                <div class="inline-flex items-center gap-2 text-pink-400 text-sm">
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    Cargando...
                </div>
            </div>

            {{-- Grid --}}
            <div wire:loading.remove class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($products as $product)
                    @include('front.partials.product-card')
                @endforeach
            </div>

            {{-- Empty state --}}
            @if($products->isEmpty())
                <div wire:loading.remove class="text-center py-16">
                    <div class="mx-auto w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-pink-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <h3 class="font-heading text-lg text-gray-700 mb-2">No se encontraron productos</h3>
                    <p class="text-sm text-gray-500 mb-4">Prueba con otros filtros o búsqueda.</p>
                    <button wire:click="clearFilters" class="text-pink-500 hover:text-pink-700 text-xs uppercase tracking-widest font-bold">Limpiar filtros</button>
                </div>
            @endif

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="mt-10">{{ $products->links() }}</div>
            @endif
        </div>
    </div>

    {{-- Mobile filter toggle --}}
    <div class="lg:hidden fixed bottom-20 left-1/2 -translate-x-1/2 z-30"
         x-data="{ open: false }">
        <button @click="open = !open; if(open) document.querySelector('aside').scrollIntoView({ behavior: 'smooth' })"
                class="bg-pink-500 text-white shadow-xl rounded-full px-5 py-3 text-xs font-bold uppercase tracking-widest flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
            Filtros
        </button>
    </div>
</div>
