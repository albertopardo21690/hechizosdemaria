@php $dt = \App\Models\SiteSetting::designTokens(); @endphp
<style>
    :root {
        --hdm-primary-color: {{ $dt['primary_color'] }};
        --hdm-secondary-color: {{ $dt['secondary_color'] }};
        --hdm-accent-color: {{ $dt['accent_color'] }};
        --hdm-text-color: {{ $dt['text_color'] }};
        --hdm-heading-font: '{{ $dt['heading_font'] }}', serif;
        --hdm-body-font: '{{ $dt['body_font'] }}', sans-serif;
    }
</style>
