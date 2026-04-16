@php $h = match($block['props']['height'] ?? 'md') { 'sm' => 'h-8', 'md' => 'h-16', 'lg' => 'h-24', 'xl' => 'h-40', default => 'h-16' }; @endphp
<div class="{{ $h }}"></div>
