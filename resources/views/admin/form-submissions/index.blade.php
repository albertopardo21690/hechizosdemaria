@extends('admin.layouts.app')
@section('title', 'Envíos de formulario')
@section('page_title', 'Envíos de formulario ('.$submissions->total().')')

@section('content')
@if($forms->count())
    <div class="flex items-center gap-2 mb-4 text-sm">
        <a href="{{ route('admin.form-submissions.index') }}" class="px-3 py-1.5 rounded border {{ ! request('form') ? 'border-pink-500 bg-pink-50 text-pink-700' : 'border-pink-200 text-gray-600 hover:bg-pink-50' }}">Todos</a>
        @foreach($forms as $f)
            <a href="{{ route('admin.form-submissions.index', ['form' => $f]) }}" class="px-3 py-1.5 rounded border {{ request('form') === $f ? 'border-pink-500 bg-pink-50 text-pink-700' : 'border-pink-200 text-gray-600 hover:bg-pink-50' }}">{{ $f }}</a>
        @endforeach
    </div>
@endif

<div class="bg-white border border-pink-200 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-pink-50 text-left text-xs uppercase tracking-widest text-gray-600">
            <tr>
                <th class="px-4 py-3">Form</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Recibido</th>
                <th class="px-4 py-3">Resumen</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($submissions as $s)
                <tr class="border-t border-pink-100 hover:bg-pink-50/30 {{ $s->is_read ? '' : 'font-semibold' }}">
                    <td class="px-4 py-3 text-xs font-mono">{{ $s->form_name }}</td>
                    <td class="px-4 py-3 text-gray-700">{{ $s->email ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $s->created_at->diffForHumans() }}</td>
                    <td class="px-4 py-3 text-gray-600 text-xs truncate max-w-sm">
                        {{ \Illuminate\Support\Str::limit(collect($s->data)->take(3)->map(fn ($v, $k) => $k.': '.(is_scalar($v) ? $v : json_encode($v)))->implode(' · '), 120) }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.form-submissions.show', $s) }}" class="text-pink-600 text-xs uppercase tracking-widest font-semibold">Ver</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-12 text-center text-gray-500">Sin envíos aún.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $submissions->links() }}</div>
@endsection
