@php
    $cols = $section['columns'] ?? [];
    $settings = $section['settings'] ?? [];
    $bg = $settings['background'] ?? 'transparent';
    $padding = $settings['padding'] ?? 'md';
    $fullWidth = $settings['full_width'] ?? false;
    $isSingleCol = count($cols) === 1;
    $hasCustomSettings = $bg !== 'transparent' || $padding !== 'md' || $fullWidth;

    $renderWidget = function (array $widget) {
        $style = $widget['style'] ?? [];
        $advanced = $widget['advanced'] ?? [];
        $classes = [];
        $mt = $style['margin_top'] ?? null;
        $mb = $style['margin_bottom'] ?? null;
        $ta = $style['text_align'] ?? null;
        if ($mt) {
            $classes[] = match ($mt) {
                'none' => 'mt-0',
                'sm' => 'mt-2',
                'lg' => 'mt-12',
                default => 'mt-6',
            };
        }
        if ($mb) {
            $classes[] = match ($mb) {
                'none' => 'mb-0',
                'sm' => 'mb-2',
                'lg' => 'mb-12',
                default => 'mb-6',
            };
        }
        if ($ta) {
            $classes[] = match ($ta) {
                'left' => 'text-left',
                'center' => 'text-center',
                'right' => 'text-right',
                default => '',
            };
        }
        if (! empty($advanced['hide_mobile'])) {
            $classes[] = 'hidden md:block';
        }
        if (! empty($advanced['hide_desktop'])) {
            $classes[] = 'md:hidden';
        }
        if (! empty($advanced['css_class'])) {
            $classes[] = $advanced['css_class'];
        }
        $cls = trim(implode(' ', array_filter($classes)));

        return ['classes' => $cls];
    };
@endphp

@if($isSingleCol && ! $hasCustomSettings)
    @foreach(($cols[0]['widgets'] ?? []) as $widget)
        @php $meta = $renderWidget($widget); @endphp
        @if($meta['classes'])
            <div class="{{ $meta['classes'] }}">
                @includeIf('front.blocks.'.$widget['type'], ['block' => $widget])
            </div>
        @else
            @includeIf('front.blocks.'.$widget['type'], ['block' => $widget])
        @endif
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
                                @php $meta = $renderWidget($widget); @endphp
                                <div class="{{ $meta['classes'] }}">
                                    @includeIf('front.blocks.'.$widget['type'], ['block' => $widget])
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @else
                @foreach(($cols[0]['widgets'] ?? []) as $widget)
                    @php $meta = $renderWidget($widget); @endphp
                    @if($meta['classes'])
                        <div class="{{ $meta['classes'] }}">
                            @includeIf('front.blocks.'.$widget['type'], ['block' => $widget])
                        </div>
                    @else
                        @includeIf('front.blocks.'.$widget['type'], ['block' => $widget])
                    @endif
                @endforeach
            @endif
        </div>
    </section>
@endif
