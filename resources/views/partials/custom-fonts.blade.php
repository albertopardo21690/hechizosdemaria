@php
    $fonts = \App\Models\CustomFont::all();
@endphp
@if($fonts->count())
    <style>
        @foreach($fonts as $f)
            @font-face {
                font-family: '{{ $f->family_name }}';
                src: url('{{ $f->url() }}') format('{{ $f->format }}');
                font-weight: {{ $f->weight }};
                font-style: {{ $f->style }};
                font-display: swap;
            }
        @endforeach
    </style>
@endif
