<header class="sticky top-0 z-40 backdrop-blur-md bg-mystic-900/80 border-b border-gold-500/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex flex-col">
                <span class="font-heading text-2xl text-shimmer leading-none">Hechizos</span>
                <span class="font-heading text-xs tracking-[0.3em] text-gold-400 uppercase">de Maria</span>
            </a>

            <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold tracking-wider uppercase">
                <a href="{{ route('page', 'sobre-mi') }}" class="hover:text-gold-400 transition">Sobre mi</a>
                <a href="{{ route('collection', 'lecturas') }}" class="hover:text-gold-400 transition">Lecturas</a>
                <a href="{{ route('page', 'tarot-24h') }}" class="hover:text-gold-400 transition">Tarot 24h</a>
                <a href="{{ route('collection', 'rituales') }}" class="hover:text-gold-400 transition">Rituales</a>
                <a href="{{ route('shop') }}" class="hover:text-gold-400 transition">Tienda</a>
                <a href="{{ route('contact') }}" class="hover:text-gold-400 transition">Contacto</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="{{ route('cart') }}" class="relative p-2 text-gold-400 hover:text-gold-300 transition" aria-label="Carrito">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                </a>
                <button class="lg:hidden text-gold-400" onclick="document.getElementById('mobile-nav').classList.toggle('hidden')" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>

        <nav id="mobile-nav" class="hidden lg:hidden py-4 flex-col gap-3 text-sm font-semibold uppercase tracking-wider border-t border-gold-500/20">
            <a href="{{ route('page', 'sobre-mi') }}" class="block py-2 hover:text-gold-400">Sobre mi</a>
            <a href="{{ route('collection', 'lecturas') }}" class="block py-2 hover:text-gold-400">Lecturas</a>
            <a href="{{ route('page', 'tarot-24h') }}" class="block py-2 hover:text-gold-400">Tarot 24h</a>
            <a href="{{ route('collection', 'rituales') }}" class="block py-2 hover:text-gold-400">Rituales</a>
            <a href="{{ route('shop') }}" class="block py-2 hover:text-gold-400">Tienda</a>
            <a href="{{ route('contact') }}" class="block py-2 hover:text-gold-400">Contacto</a>
        </nav>
    </div>
</header>
