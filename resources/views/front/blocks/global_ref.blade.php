@php
    $tid = $block['props']['template_id'] ?? null;
    $tpl = $tid ? \App\Models\PageTemplate::find($tid) : null;
@endphp
@if($tpl && is_array($tpl->payload))
    @php
        $payload = $tpl->payload;
        $sections = isset($payload['columns']) ? [$payload] : (array) $payload;
    @endphp
    @foreach($sections as $section)
        @if(is_array($section) && isset($section['columns']))
            @include('front.sections.wrapper', ['section' => $section])
        @endif
    @endforeach
@endif
