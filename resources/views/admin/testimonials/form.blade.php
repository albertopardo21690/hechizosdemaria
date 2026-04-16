@extends('admin.layouts.app')
@section('title', $testimonial ? 'Editar testimonio' : 'Nuevo testimonio')
@section('page_title', $testimonial ? 'Editar testimonio' : 'Nuevo testimonio')

@section('content')
<form method="POST" action="{{ $testimonial ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" class="max-w-3xl space-y-6">
    @csrf @if($testimonial) @method('PUT') @endif

    <section class="bg-white border border-pink-200 rounded-xl p-6 space-y-4">
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $testimonial?->name) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Ubicación</label>
                <input type="text" name="location" value="{{ old('location', $testimonial?->location) }}" placeholder="Madrid, España" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
            </div>
        </div>
        <div>
            <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Testimonio *</label>
            <textarea name="text" rows="5" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">{{ old('text', $testimonial?->text) }}</textarea>
        </div>
        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">★</label>
                <select name="rating" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                    @for($i=1;$i<=5;$i++)
                        <option value="{{ $i }}" @selected(old('rating', $testimonial?->rating ?? 5) == $i)>{{ str_repeat('★', $i) }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Servicio</label>
                <select name="service_type" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                    <option value="">-</option>
                    @foreach(['lectura'=>'Lectura','ritual'=>'Ritual','producto'=>'Producto','curso'=>'Curso','otro'=>'Otro'] as $k => $v)
                        <option value="{{ $k }}" @selected(old('service_type', $testimonial?->service_type) === $k)>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Orden</label>
                <input type="number" name="sort" value="{{ old('sort', $testimonial?->sort ?? 0) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
            </div>
        </div>
        <div class="flex gap-6">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="featured" value="1" @checked(old('featured', $testimonial?->featured)) class="accent-pink-500">
                Destacado en home
            </label>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="approved" value="1" @checked(old('approved', $testimonial?->approved)) class="accent-pink-500">
                Aprobado
            </label>
        </div>
    </section>

    <div class="flex gap-3">
        <button type="submit" class="bg-gradient-to-br from-pink-600 to-pink-500 text-white font-bold uppercase tracking-widest text-sm px-8 py-3 rounded-md">{{ $testimonial ? 'Guardar' : 'Crear' }}</button>
        @if($testimonial)
            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Eliminar testimonio?')">
                @csrf @method('DELETE')
                <button type="submit" class="border border-red-300 text-red-600 hover:bg-red-50 text-xs uppercase tracking-widest font-semibold px-6 py-3 rounded-md">Eliminar</button>
            </form>
        @endif
    </div>
</form>
@endsection
