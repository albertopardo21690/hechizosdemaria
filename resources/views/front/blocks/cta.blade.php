@php $p = $block['props']; $bg = match($p['background'] ?? 'pink') { 'white' => 'bg-white', 'light' => 'bg-pink-50', 'pink' => 'bg-gradient-to-br from-pink-500 via-pink-400 to-pink-600 text-white', default => 'bg-gradient-to-br from-pink-500 via-pink-400 to-pink-600 text-white' }; @endphp
<section class="py-16">
    <div class="max-w-5xl mx-auto px-4">
        <div class="{{ $bg }} rounded-3xl p-10 md:p-16 text-center shadow-lg">
            <h2 class="font-heading text-3xl md:text-4xl mb-4 {{ in_array($p['background'] ?? 'pink', ['white','light']) ? 'text-pink-700' : 'text-white' }}">{{ \App\Support\DynamicContent::render($p['heading'] ?? '') }}</h2>
            @if($p['body'] ?? null)<p class="mb-8 max-w-2xl mx-auto {{ in_array($p['background'] ?? 'pink', ['white','light']) ? 'text-gray-700' : 'text-white/90' }}">{{ \App\Support\DynamicContent::render($p['body']) }}</p>@endif
            <div class="flex flex-wrap gap-4 justify-center">
                @if($p['primary_text'] ?? null)
                    <a href="{{ \App\Support\DynamicContent::render($p['primary_url'] ?? '#') }}" class="inline-flex items-center justify-center px-8 py-3 rounded-md font-bold uppercase text-sm tracking-widest {{ in_array($p['background'] ?? 'pink', ['white','light']) ? 'bg-pink-500 hover:bg-pink-600 text-white' : 'bg-white hover:bg-gray-50 text-pink-600' }} transition">{{ \App\Support\DynamicContent::render($p['primary_text']) }}</a>
                @endif
                @if($p['secondary_text'] ?? null)
                    <a href="{{ \App\Support\DynamicContent::render($p['secondary_url'] ?? '#') }}" class="inline-flex items-center justify-center px-8 py-3 rounded-md font-bold uppercase text-sm tracking-widest border-2 {{ in_array($p['background'] ?? 'pink', ['white','light']) ? 'border-pink-500 text-pink-600 hover:bg-pink-50' : 'border-white text-white hover:bg-white/10' }} transition">{{ \App\Support\DynamicContent::render($p['secondary_text']) }}</a>
                @endif
            </div>
        </div>
    </div>
</section>
