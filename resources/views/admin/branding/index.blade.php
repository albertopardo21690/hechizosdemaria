@extends('admin.layouts.app')
@section('title', 'Branding')
@section('page_title', 'Branding')

@section('content')
<p class="text-gray-600 mb-8 max-w-2xl">Sube aqui el logo oficial, las fotos de Maria Jose y otras imagenes de marca. Se guardan en <code class="bg-pink-50 px-2 py-0.5 rounded text-pink-700">/public/images/branding/</code> y se usan en toda la web.</p>

<div class="grid lg:grid-cols-2 gap-6">
    @foreach($slots as $slot)
        <div class="bg-white border border-pink-200 rounded-xl p-6">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-heading text-lg text-pink-700">{{ $slot['label'] }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $slot['description'] }}</p>
                </div>
                @if($slot['exists'])
                    <span class="text-[10px] uppercase tracking-widest bg-green-100 text-green-700 px-2 py-1 rounded">Subida</span>
                @else
                    <span class="text-[10px] uppercase tracking-widest bg-gray-100 text-gray-500 px-2 py-1 rounded">Sin archivo</span>
                @endif
            </div>

            <div class="aspect-[4/3] bg-pink-50/50 border-2 border-dashed border-pink-200 rounded-lg overflow-hidden flex items-center justify-center mb-4">
                @if($slot['exists'])
                    <img src="{{ $slot['url'] }}" alt="{{ $slot['label'] }}" class="max-w-full max-h-full object-contain">
                @else
                    <div class="text-center text-gray-400 p-8">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-xs">Ninguna imagen subida</p>
                    </div>
                @endif
            </div>

            @if($slot['exists'])
                <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                    <span class="font-mono">{{ basename($slot['url']) }}</span>
                    <span>{{ $slot['size'] }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.branding.upload', $slot['key']) }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <input type="file" name="file" required accept="{{ $slot['accept'] }}"
                       class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-pink-500 file:text-white hover:file:bg-pink-600 file:cursor-pointer cursor-pointer border border-gray-200 rounded-md p-2">
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 hover:to-pink-400 text-white font-semibold text-sm uppercase tracking-widest py-2 rounded-md transition">
                        {{ $slot['exists'] ? 'Reemplazar' : 'Subir' }}
                    </button>
                    @if($slot['exists'])
                        <button type="submit" formaction="{{ route('admin.branding.delete', $slot['key']) }}" onclick="return confirm('¿Seguro que quieres eliminar {{ $slot['label'] }}?')" class="px-4 border border-red-300 text-red-600 hover:bg-red-50 text-sm uppercase tracking-widest rounded-md transition">
                            Eliminar
                        </button>
                    @endif
                </div>
            </form>
        </div>
    @endforeach
</div>

@error('file')
    <div class="mt-6 bg-red-50 border border-red-200 text-red-800 rounded-md px-4 py-3 text-sm">
        {{ $message }}
    </div>
@enderror
@endsection
