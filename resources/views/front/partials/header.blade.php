<header class="sticky top-0 z-40 backdrop-blur-md bg-white/95 border-b border-pink-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="/images/branding/Logo-Hechizos-de-Maria.png" alt="Hechizos de María" class="h-14 w-auto">
            </a>

            <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold tracking-wider uppercase text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-pink-500 transition">Inicio</a>
                <a href="{{ route('page', 'sobre-mi') }}" class="hover:text-pink-500 transition">Sobre mí</a>
                <a href="{{ route('shop') }}" class="hover:text-pink-500 transition">Tienda</a>
                <a href="{{ route('collection', 'lecturas') }}" class="hover:text-pink-500 transition">Lecturas</a>
                <a href="{{ route('booking') }}" class="hover:text-pink-500 transition">Reservar</a>
                <a href="{{ route('collection', 'rituales') }}" class="hover:text-pink-500 transition">Rituales</a>
                <a href="{{ route('contact') }}" class="hover:text-pink-500 transition">Contacto</a>
            </nav>

            <div class="flex items-center gap-4">
                {{-- Account --}}
                @if(\Illuminate\Support\Facades\Auth::guard('customer')->check())
                    <a href="{{ route('account.dashboard') }}" class="hidden sm:flex items-center gap-1.5 text-gray-500 hover:text-pink-500 transition" title="Mi cuenta">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </a>
                @else
                    <a href="{{ route('customer.login') }}" class="hidden sm:flex items-center gap-1.5 text-gray-500 hover:text-pink-500 transition text-xs font-semibold uppercase tracking-widest" title="Entrar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </a>
                @endif

                <livewire:cart-icon />

                <button class="lg:hidden text-pink-500" onclick="document.getElementById('mobile-nav').classList.toggle('hidden')" aria-label="Menú">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>

        <nav id="mobile-nav" class="hidden lg:hidden py-4 flex-col gap-3 text-sm font-semibold uppercase tracking-wider text-gray-600 border-t border-pink-100">
            <a href="{{ route('home') }}" class="block py-2 hover:text-pink-500">Inicio</a>
            <a href="{{ route('page', 'sobre-mi') }}" class="block py-2 hover:text-pink-500">Sobre mí</a>
            <a href="{{ route('shop') }}" class="block py-2 hover:text-pink-500">Tienda</a>
            <a href="{{ route('collection', 'lecturas') }}" class="block py-2 hover:text-pink-500">Lecturas</a>
            <a href="{{ route('booking') }}" class="block py-2 hover:text-pink-500">Reservar</a>
            <a href="{{ route('collection', 'rituales') }}" class="block py-2 hover:text-pink-500">Rituales</a>
            <a href="{{ route('contact') }}" class="block py-2 hover:text-pink-500">Contacto</a>
            @if(\Illuminate\Support\Facades\Auth::guard('customer')->check())
                <a href="{{ route('account.dashboard') }}" class="block py-2 hover:text-pink-500">Mi cuenta</a>
            @else
                <a href="{{ route('customer.login') }}" class="block py-2 hover:text-pink-500">Entrar</a>
            @endif
        </nav>
    </div>
</header>
