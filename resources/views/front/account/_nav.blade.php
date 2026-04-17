@php $active = fn($route) => request()->routeIs($route) ? 'bg-pink-100 text-pink-700 font-semibold' : 'text-gray-600 hover:bg-pink-50 hover:text-pink-600'; @endphp
<nav class="space-y-1">
    <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 rounded-md text-sm {{ $active('account.dashboard') }}">Resumen</a>
    <a href="{{ route('account.orders') }}" class="block px-4 py-2 rounded-md text-sm {{ $active('account.orders') }} {{ $active('account.order') }}">Mis pedidos</a>
    <a href="{{ route('account.profile') }}" class="block px-4 py-2 rounded-md text-sm {{ $active('account.profile') }}">Mi perfil</a>
    <form method="POST" action="{{ route('customer.logout') }}" class="mt-4 pt-4 border-t border-pink-100">
        @csrf
        <button type="submit" class="block w-full text-left px-4 py-2 rounded-md text-sm text-gray-500 hover:bg-red-50 hover:text-red-600">Cerrar sesión</button>
    </form>
</nav>
