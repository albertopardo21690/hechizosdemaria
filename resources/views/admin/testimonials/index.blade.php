@extends('admin.layouts.app')
@section('title', 'Testimonios')
@section('page_title', 'Testimonios ('.$testimonials->total().')')

@section('content')
<div class="mb-6 text-right">
    <a href="{{ route('admin.testimonials.create') }}" class="bg-gradient-to-br from-pink-600 to-pink-500 text-white font-semibold text-sm uppercase tracking-widest px-5 py-2.5 rounded-md">+ Nuevo</a>
</div>

<div class="bg-white border border-pink-200 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-pink-50 text-left text-xs uppercase tracking-widest text-gray-600">
            <tr><th class="px-4 py-3">Nombre</th><th class="px-4 py-3">Texto</th><th class="px-4 py-3">★</th><th class="px-4 py-3">Destacado</th><th class="px-4 py-3">Aprobado</th><th class="px-4 py-3"></th></tr>
        </thead>
        <tbody>
            @forelse($testimonials as $t)
                <tr class="border-t border-pink-100 hover:bg-pink-50/30">
                    <td class="px-4 py-3 font-semibold">{{ $t->name }}@if($t->location)<br><span class="text-xs text-gray-500">{{ $t->location }}</span>@endif</td>
                    <td class="px-4 py-3 text-gray-600">{{ Str::limit($t->text, 80) }}</td>
                    <td class="px-4 py-3 text-pink-600">{{ str_repeat('★', $t->rating) }}</td>
                    <td class="px-4 py-3">{{ $t->featured ? '✓' : '—' }}</td>
                    <td class="px-4 py-3">{{ $t->approved ? '✓' : '—' }}</td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('admin.testimonials.edit', $t) }}" class="text-pink-600 text-xs uppercase tracking-widest font-semibold">Editar</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-12 text-center text-gray-500">Sin testimonios. <a href="{{ route('admin.testimonials.create') }}" class="text-pink-600 underline">Crear primero</a>.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $testimonials->links() }}</div>
@endsection
