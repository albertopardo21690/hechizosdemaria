<!DOCTYPE html>
<html lang="es" class="bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | Hechizos de Maria</title>
    <meta name="robots" content="noindex, nofollow">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Cinzel:wght@500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/admin-builder.js', 'resources/js/rich-editor.js'])
    @livewireStyles
    @include('partials.custom-fonts')
</head>
<body class="min-h-screen bg-gray-50 text-gray-900" style="background: linear-gradient(180deg, #fff 0%, #fdf2f8 100%) fixed;">

    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        <aside class="w-64 bg-white border-r border-pink-200 flex flex-col fixed inset-y-0 z-20">
            <div class="h-20 flex items-center justify-center border-b border-pink-200 px-4">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="/images/branding/Logo-Hechizos-de-Maria.png" alt="Hechizos de Maria" class="h-12 w-auto">
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 text-sm">
                @php
                    $menu = [
                        ['Dashboard', 'admin.dashboard', 'chart'],
                        ['Productos', 'admin.products.index', 'tag'],
                        ['Pedidos', 'admin.orders.index', 'cart'],
                        ['Clientes', 'admin.customers.index', 'users'],
                        ['Colecciones', 'admin.collections.index', 'grid'],
                        ['Paginas', 'admin.pages.index', 'document'],
                        ['Testimonios', 'admin.testimonials.index', 'chat'],
                        ['Blog', 'admin.blog.index', 'newspaper'],
                        ['Archivos', 'admin.media.index', 'folder'],
                        ['Branding', 'admin.branding.index', 'image'],
                        ['Theme Builder', 'admin.theme-builder.index', 'layout'],
                        ['Reservas', 'admin.bookings.index', 'calendar'],
                        ['Serv. reservables', 'admin.bookings.services', 'bookmark'],
                        ['Envíos formularios', 'admin.form-submissions.index', 'mail'],
                        ['Fuentes', 'admin.custom-fonts.index', 'type'],
                        ['Design Tokens', 'admin.design-tokens.index', 'palette'],
                    ];
                    $icons = [
                        'chart' => 'M3 3v18h18M7 14v3m5-8v8m5-5v5',
                        'tag' => 'M7 7h.01M7 3h5a2 2 0 011.41.59l7 7a2 2 0 010 2.82l-5 5a2 2 0 01-2.82 0l-7-7A2 2 0 014 10V5a2 2 0 012-2z',
                        'cart' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m14-9l2 9M9 22a1 1 0 100-2 1 1 0 000 2m10 0a1 1 0 100-2 1 1 0 000 2',
                        'users' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6 5.87v-2a4 4 0 00-4-4H7m10 6v-2a4 4 0 00-3-3.87M13 7a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 11-6 0 3 3 0 016 0z',
                        'grid' => 'M4 6h16M4 10h16M4 14h16M4 18h16',
                        'document' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                        'chat' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.836L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
                        'newspaper' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
                        'image' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
                        'layout' => 'M4 5a2 2 0 012-2h12a2 2 0 012 2v2H4V5zm0 4h16v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9zm4 3v6M12 12v6m4-6v6',
                        'mail' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                        'type' => 'M4 7V4h16v3M9 20h6M12 4v16',
                        'folder' => 'M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z',
                        'palette' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
                        'calendar' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                        'bookmark' => 'M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z',
                    ];
                @endphp

                @foreach($menu as [$label, $route, $icon])
                    @php $active = request()->routeIs($route) || request()->routeIs(str_replace('.index', '.*', $route)); @endphp
                    <a href="{{ route($route) }}"
                       class="flex items-center gap-3 px-5 py-2.5 transition border-l-4 {{ $active ? 'border-pink-500 bg-pink-50 text-pink-700 font-semibold' : 'border-transparent text-gray-700 hover:bg-pink-50/70 hover:text-pink-600' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$icon] }}"/></svg>
                        {{ $label }}
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-pink-200 p-4 text-xs text-gray-500">
                <div class="mb-2">
                    <span class="font-semibold text-gray-900">{{ auth('staff')->user()?->firstname }} {{ auth('staff')->user()?->lastname }}</span><br>
                    <span>{{ auth('staff')->user()?->email }}</span>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="text-pink-600 hover:text-pink-700 font-semibold uppercase tracking-widest">Cerrar sesion</button>
                </form>
            </div>
        </aside>

        {{-- MAIN --}}
        <div class="flex-1 ml-64">
            <header class="h-20 bg-white border-b border-pink-200 flex items-center justify-between px-8 sticky top-0 z-10">
                <h1 class="font-heading text-2xl text-pink-700">@yield('page_title', 'Admin')</h1>
                <a href="{{ route('home') }}" target="_blank" class="text-sm text-gray-600 hover:text-pink-600 inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Ver sitio
                </a>
            </header>

            <main class="p-8">
                @if(session('status'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-md px-4 py-3">
                        {{ session('status') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <livewire:admin.media-picker />
    @livewireScripts
</body>
</html>
