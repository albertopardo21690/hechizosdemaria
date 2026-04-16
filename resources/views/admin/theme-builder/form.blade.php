@extends('admin.layouts.app')
@section('title', 'Editar: '.$template->name)
@section('page_title', 'Plantilla: '.$template->name)

@section('content')

<form method="POST" action="{{ route('admin.theme-builder.update', $template) }}" class="grid lg:grid-cols-[1fr_300px] gap-6 mb-8">
    @csrf @method('PUT')
    <section class="bg-white border border-pink-200 rounded-xl p-6 space-y-4">
        <h2 class="font-heading text-lg text-pink-700 mb-3">Configuración</h2>
        <div>
            <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Nombre *</label>
            <input type="text" name="name" value="{{ old('name', $template->name) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
            @error('name')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Ubicación</label>
                <input type="text" value="{{ \App\Models\ThemeTemplate::LOCATIONS[$template->location] ?? $template->location }}" readonly class="w-full border border-gray-200 bg-gray-50 rounded-md px-3 py-2 text-gray-500">
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Prioridad</label>
                <input type="number" name="priority" value="{{ old('priority', $template->priority) }}" min="0" max="100" class="w-full border border-gray-300 rounded-md px-3 py-2">
                <p class="text-[10px] text-gray-400 mt-1">Si hay varias activas, gana la de mayor prioridad.</p>
            </div>
        </div>

        @if($template->location === 'popup')
            <hr class="border-pink-200 my-2">
            <h3 class="font-heading text-pink-700 mb-3">Configuración del popup</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Tipo de activación</label>
                    <select name="trigger_type" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        @foreach(\App\Models\ThemeTemplate::TRIGGERS as $k => $label)
                            <option value="{{ $k }}" @selected(old('trigger_type', $template->trigger_type ?? 'time') === $k)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Valor</label>
                    <input type="number" name="trigger_value" value="{{ old('trigger_value', $template->trigger_value ?? 5) }}" min="0" max="100000" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <p class="text-[10px] text-gray-400 mt-1">Segundos para "tiempo", porcentaje para "scroll", se ignora para los demás.</p>
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Frecuencia</label>
                    <select name="frequency" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        @foreach(\App\Models\ThemeTemplate::FREQUENCIES as $k => $label)
                            <option value="{{ $k }}" @selected(old('frequency', $template->frequency ?? 'session') === $k)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Ancho máximo</label>
                    <select name="max_width" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="sm" @selected(old('max_width', $template->max_width) === 'sm')>Pequeño (400px)</option>
                        <option value="md" @selected(old('max_width', $template->max_width ?? 'md') === 'md')>Medio (600px)</option>
                        <option value="lg" @selected(old('max_width', $template->max_width) === 'lg')>Grande (800px)</option>
                        <option value="xl" @selected(old('max_width', $template->max_width) === 'xl')>Extra (1000px)</option>
                        <option value="full" @selected(old('max_width', $template->max_width) === 'full')>Ancho completo</option>
                    </select>
                </div>
            </div>
        @endif
    </section>

    <aside class="space-y-4">
        <section class="bg-white border border-pink-200 rounded-xl p-6 space-y-3">
            <div>
                <p class="text-xs uppercase tracking-widest text-gray-600 mb-1">Estado</p>
                @if($template->is_active)
                    <span class="inline-block text-xs uppercase tracking-widest bg-green-100 text-green-700 px-3 py-1 rounded-full">● Activa en el sitio</span>
                @else
                    <span class="inline-block text-xs uppercase tracking-widest bg-gray-100 text-gray-500 px-3 py-1 rounded-full">● Borrador (no visible)</span>
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <button type="submit" class="w-full bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 hover:to-pink-400 text-white font-bold uppercase tracking-widest text-sm py-3 rounded-md">Guardar ajustes</button>
            </div>
        </section>
        <section class="bg-white border border-pink-200 rounded-xl p-6">
            <p class="text-xs uppercase tracking-widest text-gray-600 mb-2">Acciones</p>
            <a href="{{ route('admin.theme-builder.index') }}" class="block text-xs text-pink-600 hover:text-pink-800 uppercase tracking-widest font-semibold">← Volver al listado</a>
        </section>
    </aside>
</form>

<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="font-heading text-2xl text-pink-700">Contenido · Page Builder</h2>
        <p class="text-xs text-gray-500">Los bloques se guardan automáticamente al editarlos.</p>
    </div>
    <form method="POST" action="{{ route('admin.theme-builder.toggle', $template) }}">
        @csrf
        <button type="submit" class="text-xs uppercase tracking-widest font-semibold px-4 py-2 rounded-md {{ $template->is_active ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-pink-500 text-white hover:bg-pink-600' }}">
            {{ $template->is_active ? 'Desactivar' : 'Activar en el sitio' }}
        </button>
    </form>
</div>

<livewire:admin.theme-template-builder :template="$template" :key="'theme-builder-'.$template->id" />

<form method="POST" action="{{ route('admin.theme-builder.destroy', $template) }}" class="mt-10 text-right" onsubmit="return confirm('¿Eliminar esta plantilla permanentemente?')">
    @csrf @method('DELETE')
    <button type="submit" class="border border-red-300 text-red-600 hover:bg-red-50 text-xs uppercase tracking-widest font-semibold px-6 py-2.5 rounded-md">Eliminar plantilla</button>
</form>
@endsection
