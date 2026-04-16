@extends('admin.layouts.app')
@section('title', 'Páginas')
@section('page_title', 'Páginas ('.$pages->total().')')

@section('content')
<div class="mb-6 text-right">
    <a href="{{ route('admin.pages.create') }}" class="bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 hover:to-pink-400 text-white font-semibold text-sm uppercase tracking-widest px-5 py-2.5 rounded-md transition">+ Nueva página</a>
</div>

<div class="bg-white border border-pink-200 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-pink-50 text-left text-xs uppercase tracking-widest text-gray-600">
            <tr><th class="px-4 py-3">Título</th><th class="px-4 py-3">Slug</th><th class="px-4 py-3">Estado</th><th class="px-4 py-3">Plantilla</th><th class="px-4 py-3"></th></tr>
        </thead>
        <tbody>
            @forelse($pages as $p)
                <tr class="border-t border-pink-100 hover:bg-pink-50/30">
                    <td class="px-4 py-3 font-semibold"><a href="{{ route('admin.pages.edit', $p) }}" class="hover:text-pink-600">{{ $p->title }}</a></td>
                    <td class="px-4 py-3 text-xs font-mono text-gray-600">/{{ $p->slug }}</td>
                    <td class="px-4 py-3"><span class="inline-block px-2 py-0.5 rounded-full text-xs {{ $p->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ $p->status }}</span></td>
                    <td class="px-4 py-3 text-gray-600">{{ $p->template }}</td>
                    <td class="px-4 py-3 text-right"><a href="{{ route('admin.pages.edit', $p) }}" class="text-pink-600 text-xs uppercase tracking-widest font-semibold">Editar</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-12 text-center text-gray-500">Sin páginas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $pages->links() }}</div>
@endsection
