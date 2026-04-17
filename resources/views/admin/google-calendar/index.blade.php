@extends('admin.layouts.app')
@section('title', 'Google Calendar')
@section('page_title', 'Sincronización con Google Calendar')

@section('content')
<div class="max-w-2xl space-y-6">
    <div class="bg-white border border-pink-200 rounded-xl p-6">
        <h2 class="font-heading text-lg text-pink-700 mb-4">Estado de conexión</h2>
        @if($connected)
            <div class="flex items-center gap-3 mb-4">
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <span class="text-green-700 font-semibold">Conectado a Google Calendar</span>
            </div>
            <p class="text-sm text-gray-600 mb-4">Las reservas aceptadas se sincronizan automáticamente al calendario de María José.</p>
            <form method="POST" action="{{ route('admin.google-calendar.disconnect') }}">
                @csrf
                <button type="submit" class="border border-red-300 text-red-600 hover:bg-red-50 text-xs uppercase tracking-widest font-semibold px-4 py-2 rounded-md">Desconectar</button>
            </form>
        @else
            <div class="flex items-center gap-3 mb-4">
                <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                <span class="text-gray-600">No conectado</span>
            </div>
            @if($clientId)
                <a href="{{ route('admin.google-calendar.authorize') }}" class="inline-flex items-center gap-2 bg-gradient-to-br from-pink-600 to-pink-500 text-white font-bold text-xs uppercase tracking-widest px-5 py-2.5 rounded-md">
                    Conectar con Google
                </a>
            @else
                <p class="text-sm text-gray-500">Primero configura las credenciales OAuth2 abajo.</p>
            @endif
        @endif
    </div>

    <form method="POST" action="{{ route('admin.google-calendar.save') }}" class="bg-white border border-pink-200 rounded-xl p-6 space-y-4">
        @csrf
        <h2 class="font-heading text-lg text-pink-700 mb-2">Credenciales OAuth2</h2>
        <p class="text-xs text-gray-500 mb-3">Crea un proyecto en <a href="https://console.cloud.google.com/apis/credentials" target="_blank" class="text-pink-600 underline">Google Cloud Console</a>, habilita la API de Calendar y crea credenciales OAuth2 (tipo web). Redirect URI: <code class="text-pink-700">{{ route('admin.google-calendar.callback') }}</code></p>
        <div>
            <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Client ID</label>
            <input type="text" name="google_client_id" value="{{ $clientId }}" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs">
        </div>
        <div>
            <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Client Secret</label>
            <input type="password" name="google_client_secret" value="" placeholder="••••••••" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs">
        </div>
        <div>
            <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Calendar ID (dejar vacío = primary)</label>
            <input type="text" name="google_calendar_id" value="{{ $calendarId }}" placeholder="primary" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs">
        </div>
        <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white text-xs uppercase tracking-widest font-semibold px-5 py-2.5 rounded-md">Guardar credenciales</button>
    </form>
</div>
@endsection
