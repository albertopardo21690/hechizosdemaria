<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::generate() !!}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased">

    @php
        $headerTpl = \App\Models\ThemeTemplate::activeFor('header');
        $footerTpl = \App\Models\ThemeTemplate::activeFor('footer');
    @endphp

    @if($headerTpl && $headerTpl->hasBlocks())
        <header>
            @foreach($headerTpl->sectionsNormalized() as $section)
                @include('front.sections.wrapper', ['section' => $section])
            @endforeach
        </header>
    @else
        @include('front.partials.header')
    @endif

    <main>
        @yield('content')
    </main>

    @if($footerTpl && $footerTpl->hasBlocks())
        <footer>
            @foreach($footerTpl->sectionsNormalized() as $section)
                @include('front.sections.wrapper', ['section' => $section])
            @endforeach
        </footer>
    @else
        @include('front.partials.footer')
    @endif
    @include('front.partials.whatsapp-float')
    @include('front.partials.cookie-consent')

    {{-- POPUPS --}}
    @php $popups = \App\Models\ThemeTemplate::activePopups(); @endphp
    @foreach($popups as $popup)
        @if($popup->hasBlocks())
            @php
                $mw = match($popup->max_width) {
                    'sm' => 'max-w-md',
                    'lg' => 'max-w-3xl',
                    'xl' => 'max-w-5xl',
                    'full' => 'max-w-none w-full h-full',
                    default => 'max-w-2xl',
                };
            @endphp
            <div class="hdm-popup fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4 hidden"
                 data-popup-id="{{ $popup->id }}"
                 data-trigger-type="{{ $popup->trigger_type ?? 'time' }}"
                 data-trigger-value="{{ (int) ($popup->trigger_value ?? 5) }}"
                 data-frequency="{{ $popup->frequency ?? 'always' }}">
                <div class="bg-white rounded-xl shadow-2xl w-full {{ $mw }} max-h-[90vh] overflow-auto relative">
                    <button type="button" class="hdm-popup-close absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-white/80 hover:bg-pink-50 text-gray-600 hover:text-pink-600 flex items-center justify-center shadow" aria-label="Cerrar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    @foreach($popup->sectionsNormalized() as $section)
                        @include('front.sections.wrapper', ['section' => $section])
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach

    @livewireScripts
</body>
</html>
