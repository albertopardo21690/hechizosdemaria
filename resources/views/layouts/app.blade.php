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

    @livewireScripts
</body>
</html>
