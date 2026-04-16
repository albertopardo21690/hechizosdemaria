@extends('admin.layouts.app')
@section('title', 'Theme Builder')
@section('page_title', 'Theme Builder')

@section('content')
<p class="text-sm text-gray-600 mb-6 max-w-3xl">
    Aquí creas plantillas globales para la cabecera y el pie del sitio con el mismo constructor visual.
    Solo puede haber una plantilla activa por ubicación. Si no hay ninguna activa, se usa el diseño por defecto del tema.
</p>

@foreach($locations as $key => $label)
    @php $items = $grouped[$key] ?? collect(); @endphp
    <section class="mb-8 bg-white border border-pink-200 rounded-xl overflow-hidden">
        <header class="flex items-center justify-between px-5 py-3 bg-pink-50 border-b border-pink-200">
            <h2 class="font-heading text-lg text-pink-700">{{ $label }}</h2>
            <form method="POST" action="{{ route('admin.theme-builder.create') }}">
                @csrf
                <input type="hidden" name="location" value="{{ $key }}">
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs uppercase tracking-widest font-semibold px-4 py-2 rounded-md">+ Nueva plantilla</button>
            </form>
        </header>
        <div>
            @forelse($items as $tpl)
                <div class="flex items-center justify-between px-5 py-3 border-b border-pink-100 last:border-b-0 hover:bg-pink-50/30">
                    <div class="flex items-center gap-3 min-w-0">
                        @if($tpl->is_active)
                            <span class="text-[10px] uppercase tracking-widest bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Activa</span>
                        @else
                            <span class="text-[10px] uppercase tracking-widest bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Borrador</span>
                        @endif
                        <a href="{{ route('admin.theme-builder.edit', $tpl) }}" class="font-semibold text-gray-800 hover:text-pink-600 truncate">{{ $tpl->name }}</a>
                        <span class="text-xs text-gray-500">· prioridad {{ $tpl->priority }}</span>
                        <span class="text-xs text-gray-400">· {{ $tpl->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <form method="POST" action="{{ route('admin.theme-builder.toggle', $tpl) }}">
                            @csrf
                            <button type="submit" class="text-xs uppercase tracking-widest font-semibold {{ $tpl->is_active ? 'text-gray-500 hover:text-gray-800' : 'text-pink-600 hover:text-pink-800' }}">
                                {{ $tpl->is_active ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.theme-builder.edit', $tpl) }}" class="text-pink-600 text-xs uppercase tracking-widest font-semibold hover:text-pink-800">Editar</a>
                        <form method="POST" action="{{ route('admin.theme-builder.destroy', $tpl) }}" onsubmit="return confirm('¿Eliminar esta plantilla?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 text-xs uppercase tracking-widest font-semibold hover:text-red-700">Eliminar</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-5 py-8 text-center text-sm text-gray-500">
                    No hay plantillas de {{ strtolower($label) }}. Crea la primera con el botón de arriba.
                </div>
            @endforelse
        </div>
    </section>
@endforeach
@endsection
