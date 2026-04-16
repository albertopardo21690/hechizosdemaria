@extends('admin.layouts.app')
@section('title', 'Blog')
@section('page_title', 'Blog ('.$posts->total().')')

@section('content')
<div class="mb-6 text-right">
    <a href="{{ route('admin.blog.create') }}" class="bg-gradient-to-br from-pink-600 to-pink-500 text-white font-semibold text-sm uppercase tracking-widest px-5 py-2.5 rounded-md">+ Nuevo post</a>
</div>

<div class="bg-white border border-pink-200 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-pink-50 text-left text-xs uppercase tracking-widest text-gray-600">
            <tr><th class="px-4 py-3">Título</th><th class="px-4 py-3">Categoría</th><th class="px-4 py-3">Signo</th><th class="px-4 py-3">Estado</th><th class="px-4 py-3">Publicado</th><th class="px-4 py-3"></th></tr>
        </thead>
        <tbody>
            @forelse($posts as $p)
                <tr class="border-t border-pink-100 hover:bg-pink-50/30">
                    <td class="px-4 py-3 font-semibold"><a href="{{ route('admin.blog.edit', $p) }}" class="hover:text-pink-600">{{ $p->title }}</a></td>
                    <td class="px-4 py-3 text-gray-600">{{ $p->category }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $p->zodiac_sign }}</td>
                    <td class="px-4 py-3"><span class="inline-block px-2 py-0.5 rounded-full text-xs {{ $p->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ $p->status }}</span></td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $p->published_at?->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('admin.blog.edit', $p) }}" class="text-pink-600 text-xs uppercase tracking-widest font-semibold">Editar</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-12 text-center text-gray-500">Sin posts.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $posts->links() }}</div>
@endsection
