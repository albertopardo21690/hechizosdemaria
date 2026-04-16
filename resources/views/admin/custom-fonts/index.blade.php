@extends('admin.layouts.app')
@section('title', 'Fuentes personalizadas')
@section('page_title', 'Fuentes personalizadas ('.$fonts->count().')')

@section('content')
<div class="grid lg:grid-cols-[1fr_360px] gap-6">
    <section class="bg-white border border-pink-200 rounded-xl overflow-hidden">
        <header class="px-5 py-3 bg-pink-50 border-b border-pink-200">
            <h2 class="font-heading text-lg text-pink-700">Fuentes cargadas</h2>
        </header>
        @if($fonts->isEmpty())
            <div class="p-10 text-center text-sm text-gray-500">Sin fuentes personalizadas aún.</div>
        @else
            <table class="w-full text-sm">
                <thead class="text-left text-xs uppercase tracking-widest text-gray-600">
                    <tr><th class="px-5 py-2">Nombre</th><th class="px-5 py-2">Family (CSS)</th><th class="px-5 py-2">Peso</th><th class="px-5 py-2">Estilo</th><th class="px-5 py-2">Preview</th><th class="px-5 py-2"></th></tr>
                </thead>
                <tbody>
                    @foreach($fonts as $f)
                        <tr class="border-t border-pink-100">
                            <td class="px-5 py-3 font-semibold">{{ $f->name }}</td>
                            <td class="px-5 py-3 font-mono text-xs">{{ $f->family_name }}</td>
                            <td class="px-5 py-3">{{ $f->weight }}</td>
                            <td class="px-5 py-3">{{ $f->style }}</td>
                            <td class="px-5 py-3" style="font-family: '{{ $f->family_name }}', sans-serif; font-weight: {{ $f->weight }}; font-style: {{ $f->style }}; font-size: 18px;">Aa Bb Cc · hola</td>
                            <td class="px-5 py-3 text-right">
                                <form method="POST" action="{{ route('admin.custom-fonts.destroy', $f) }}" onsubmit="return confirm('¿Eliminar esta fuente?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 text-xs uppercase tracking-widest font-semibold hover:text-red-700">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>

    <aside class="bg-white border border-pink-200 rounded-xl p-6">
        <h2 class="font-heading text-lg text-pink-700 mb-4">Subir fuente nueva</h2>
        <form method="POST" action="{{ route('admin.custom-fonts.store') }}" enctype="multipart/form-data" class="space-y-3 text-sm">
            @csrf
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Nombre visible *</label>
                <input type="text" name="name" placeholder="Playfair Display Bold" required class="w-full border border-gray-300 rounded-md px-3 py-2">
                @error('name')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Family name CSS *</label>
                <input type="text" name="family_name" placeholder="Playfair Display" required class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs">
                <p class="text-[10px] text-gray-400 mt-1">Usa este nombre en tu CSS: <code>font-family: 'nombre'</code></p>
                @error('family_name')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Peso</label>
                    <select name="weight" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="300">300 Light</option>
                        <option value="400" selected>400 Regular</option>
                        <option value="500">500 Medium</option>
                        <option value="600">600 Semibold</option>
                        <option value="700">700 Bold</option>
                        <option value="900">900 Black</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Estilo</label>
                    <select name="style" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="normal">Normal</option>
                        <option value="italic">Italic</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Archivo *</label>
                <input type="file" name="file" accept=".woff,.woff2,.ttf,.otf" required class="w-full text-xs">
                <p class="text-[10px] text-gray-400 mt-1">Recomendado WOFF2. Máx 4MB.</p>
                @error('file')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="w-full bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 text-white font-bold uppercase tracking-widest text-xs py-2.5 rounded-md">Subir fuente</button>
        </form>
    </aside>
</div>
@endsection
