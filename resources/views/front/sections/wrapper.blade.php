@php
    $cols = $section['columns'] ?? [];
    $settings = $section['settings'] ?? [];
    $bg = $settings['background'] ?? 'transparent';
    $padding = $settings['padding'] ?? 'md';
    $fullWidth = $settings['full_width'] ?? false;
    $isSingleCol = count($cols) === 1;
    $hasCustomSettings = $bg !== 'transparent' || $padding !== 'md' || $fullWidth;
@endphp

@if($isSingleCol && ! $hasCustomSettings)
    {{-- Passthrough: el widget renderiza con su propio contenedor full-width --}}
    @foreach(($cols[0]['widgets'] ?? []) as $widget)
        @includeIf('front.blocks.'.$widget['type'], ['block' => $widget])
    @endforeach
@else
    @php
        $bgClasses = match($bg) {
            'white' => 'bg-white',
            'pink-50' => 'bg-pink-50',
            'pink-gradient' => 'bg-gradient-to-br from-pink-50 via-white to-pink-100',
            default => '',
        };
        $padClasses = match($padding) {
            'none' => '',
            'sm' => 'py-6',
            'lg' => 'py-20',
            default => 'py-12',
        };
        $container = $fullWidth ? 'w-full' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8';
        $gridTemplate = collect($cols)->map(fn ($c) => ($c['width'] ?? 100).'fr')->implode(' ');
    @endphp
    <section class="{{ trim($bgClasses.' '.$padClasses) }}">
        <div class="{{ $container }}">
            @if(count($cols) > 1)
                <div class="grid gap-6 md:gap-8" style="grid-template-columns: {{ $gridTemplate }}">
                    @foreach($cols as $col)
                        <div class="space-y-4">
                            @foreach($col['widgets'] ?? [] as $widget)
                                @includeIf('front.blocks.'.$widget['type'], ['block' => $widget])
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @else
                @foreach(($cols[0]['widgets'] ?? []) as $widget)
                    @includeIf('front.blocks.'.$widget['type'], ['block' => $widget])
                @endforeach
            @endif
        </div>
    </section>
@endif
