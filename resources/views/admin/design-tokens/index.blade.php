@extends('admin.layouts.app')
@section('title', 'Design Tokens')
@section('page_title', 'Design Tokens · Variables CSS globales')

@section('content')
<p class="text-sm text-gray-600 mb-6 max-w-3xl">
    Estos valores se inyectan como variables CSS en todo el sitio (<code>--hdm-primary</code>, etc.).
    Los widgets pueden usarlos automáticamente, y tú puedes referenciarlos en clases CSS personalizadas.
</p>

<form method="POST" action="{{ route('admin.design-tokens.update') }}" class="max-w-2xl space-y-6">
    @csrf @method('PUT')

    <section class="bg-white border border-pink-200 rounded-xl p-6">
        <h2 class="font-heading text-lg text-pink-700 mb-4">Colores</h2>
        <div class="grid md:grid-cols-2 gap-4">
            @foreach(['primary_color', 'secondary_color', 'accent_color', 'text_color'] as $key)
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">{{ $tokens[$key]['label'] }}</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="{{ $key }}" value="{{ $values[$key] }}" class="w-10 h-10 rounded border border-gray-300 cursor-pointer">
                        <input type="text" value="{{ $values[$key] }}" oninput="this.previousElementSibling.value=this.value" class="flex-1 border border-gray-300 rounded-md px-3 py-2 font-mono text-xs" maxlength="20">
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1"><code>var(--hdm-{{ str_replace('_', '-', $key) }})</code></p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-white border border-pink-200 rounded-xl p-6">
        <h2 class="font-heading text-lg text-pink-700 mb-4">Tipografía</h2>
        <div class="grid md:grid-cols-2 gap-4">
            @foreach(['heading_font', 'body_font'] as $key)
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">{{ $tokens[$key]['label'] }}</label>
                    <input type="text" name="{{ $key }}" value="{{ $values[$key] }}" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <p class="text-[10px] text-gray-400 mt-1"><code>var(--hdm-{{ str_replace('_', '-', $key) }})</code></p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-pink-50 border border-pink-200 rounded-xl p-5">
        <h3 class="font-heading text-sm text-pink-700 mb-2">Preview</h3>
        <div class="flex gap-4 items-center">
            @foreach(['primary_color', 'secondary_color', 'accent_color', 'text_color'] as $key)
                <div class="text-center">
                    <div class="w-12 h-12 rounded-full border-2 border-white shadow" style="background: {{ $values[$key] }}"></div>
                    <p class="text-[10px] text-gray-500 mt-1">{{ Str::after($tokens[$key]['label'], 'Color ') }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <button type="submit" class="bg-gradient-to-br from-pink-600 to-pink-500 text-white font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-md">Guardar tokens</button>
</form>
@endsection
