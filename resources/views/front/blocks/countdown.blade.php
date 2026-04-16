@php
    $p = $block['props'];
    $due = $p['due_date'] ?? '';
    if (! $due) return;
@endphp
<div class="hdm-countdown flex justify-center gap-4 text-center" data-due="{{ $due }}" data-expire-text="{{ e($p['expire_text'] ?? '¡Finalizado!') }}">
    <div class="min-w-[70px]"><div class="hdm-cd-days text-4xl md:text-5xl font-heading text-pink-600">00</div><div class="text-xs uppercase tracking-widest text-gray-500 mt-1">{{ $p['label_days'] ?? 'Días' }}</div></div>
    <div class="min-w-[70px]"><div class="hdm-cd-hours text-4xl md:text-5xl font-heading text-pink-600">00</div><div class="text-xs uppercase tracking-widest text-gray-500 mt-1">{{ $p['label_hours'] ?? 'Horas' }}</div></div>
    <div class="min-w-[70px]"><div class="hdm-cd-minutes text-4xl md:text-5xl font-heading text-pink-600">00</div><div class="text-xs uppercase tracking-widest text-gray-500 mt-1">{{ $p['label_minutes'] ?? 'Min' }}</div></div>
    <div class="min-w-[70px]"><div class="hdm-cd-seconds text-4xl md:text-5xl font-heading text-pink-600">00</div><div class="text-xs uppercase tracking-widest text-gray-500 mt-1">{{ $p['label_seconds'] ?? 'Seg' }}</div></div>
</div>
