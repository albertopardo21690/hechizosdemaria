@extends('admin.layouts.app')
@section('title', 'Envío #'.$submission->id)
@section('page_title', 'Envío #'.$submission->id.' · '.$submission->form_name)

@section('content')
<div class="grid lg:grid-cols-[1fr_300px] gap-6">
    <section class="bg-white border border-pink-200 rounded-xl p-6">
        <h2 class="font-heading text-lg text-pink-700 mb-4">Datos enviados</h2>
        <dl class="divide-y divide-pink-100">
            @foreach($submission->data as $k => $v)
                <div class="py-3 grid grid-cols-[180px_1fr] gap-4">
                    <dt class="text-xs uppercase tracking-widest text-gray-500 font-mono">{{ $k }}</dt>
                    <dd class="text-sm text-gray-800 whitespace-pre-wrap break-words">{{ is_scalar($v) ? $v : json_encode($v, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) }}</dd>
                </div>
            @endforeach
        </dl>
    </section>

    <aside class="space-y-4">
        <section class="bg-white border border-pink-200 rounded-xl p-6 space-y-2 text-sm">
            <p class="text-xs uppercase tracking-widest text-gray-600 mb-2">Meta</p>
            <p><span class="text-gray-500">Formulario:</span> <span class="font-mono">{{ $submission->form_name }}</span></p>
            <p><span class="text-gray-500">Email:</span> {{ $submission->email ?? '—' }}</p>
            <p><span class="text-gray-500">Recibido:</span> {{ $submission->created_at->format('Y-m-d H:i') }}</p>
            <p><span class="text-gray-500">IP:</span> <span class="font-mono text-xs">{{ $submission->ip }}</span></p>
            @if($submission->source_url)
                <p><span class="text-gray-500">URL:</span> <a href="{{ $submission->source_url }}" target="_blank" class="text-pink-600 hover:underline text-xs break-all">{{ $submission->source_url }}</a></p>
            @endif
        </section>
        <section class="bg-white border border-pink-200 rounded-xl p-6 space-y-2">
            @if($submission->email)
                <a href="mailto:{{ $submission->email }}" class="block w-full text-center bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 text-white text-xs uppercase tracking-widest font-semibold py-2.5 rounded-md">Responder por email</a>
            @endif
            <form method="POST" action="{{ route('admin.form-submissions.destroy', $submission) }}" onsubmit="return confirm('¿Eliminar este envío?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full border border-red-300 text-red-600 hover:bg-red-50 text-xs uppercase tracking-widest font-semibold py-2.5 rounded-md">Eliminar</button>
            </form>
            <a href="{{ route('admin.form-submissions.index') }}" class="block text-center text-xs text-gray-500 hover:text-pink-600 uppercase tracking-widest font-semibold mt-2">← Volver al listado</a>
        </section>
    </aside>
</div>
@endsection
