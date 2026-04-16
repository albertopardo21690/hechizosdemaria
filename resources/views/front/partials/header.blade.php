<header class="sticky top-0 z-40 backdrop-blur-md bg-white/95 border-b border-pink-200/60 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="/images/branding/Logo-Hechizos-de-Maria.png" alt="Hechizos de Maria" class="h-14 w-auto">
            </a>

            <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold tracking-wider uppercase text-gray-700">
                <a href="{{ route('home') }}" class="hover:text-pink-500 transition">Home</a>
                <a href="{{ route('page', 'sobre-mi') }}" class="hover:text-pink-500 transition">Sobre mi</a>
                <a href="{{ route('shop') }}" class="hover:text-pink-500 transition">Tienda magica</a>
                <a href="{{ route('collection', 'lecturas') }}" class="hover:text-pink-500 transition">Lecturas</a>
                <a href="{{ route('page', 'tarot-24h') }}" class="hover:text-pink-500 transition">Tarot 24h</a>
                <a href="{{ route('collection', 'rituales') }}" class="hover:text-pink-500 transition">Rituales</a>
                <a href="{{ route('contact') }}" class="hover:text-pink-500 transition">Contacto</a>
            </nav>

            <div class="flex items-center gap-4">
                <livewire:cart-icon />

                <button class="lg:hidden text-pink-500" onclick="document.getElementById('mobile-nav').classList.toggle('hidden')" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>

        <nav id="mobile-nav" class="hidden lg:hidden py-4 flex-col gap-3 text-sm font-semibold uppercase tracking-wider text-gray-700 border-t border-pink-200/60">
            <a href="{{ route('home') }}" class="block py-2 hover:text-pink-500">Home</a>
            <a href="{{ route('page', 'sobre-mi') }}" class="block py-2 hover:text-pink-500">Sobre mi</a>
            <a href="{{ route('shop') }}" class="block py-2 hover:text-pink-500">Tienda magica</a>
            <a href="{{ route('collection', 'lecturas') }}" class="block py-2 hover:text-pink-500">Lecturas</a>
            <a href="{{ route('page', 'tarot-24h') }}" class="block py-2 hover:text-pink-500">Tarot 24h</a>
            <a href="{{ route('collection', 'rituales') }}" class="block py-2 hover:text-pink-500">Rituales</a>
            <a href="{{ route('contact') }}" class="block py-2 hover:text-pink-500">Contacto</a>
        </nav>
    </div>
</header>
