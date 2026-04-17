<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;

class GoogleCalendarController extends Controller
{
    public function index(GoogleCalendarService $gcal)
    {
        return view('admin.google-calendar.index', [
            'connected' => $gcal->isConfigured(),
            'clientId' => SiteSetting::get('google_client_id', ''),
            'calendarId' => SiteSetting::get('google_calendar_id', 'primary'),
        ]);
    }

    public function saveCredentials(Request $request)
    {
        $request->validate([
            'google_client_id' => 'required|string',
            'google_client_secret' => 'required|string',
            'google_calendar_id' => 'nullable|string',
        ]);
        SiteSetting::set('google_client_id', $request->input('google_client_id'));
        SiteSetting::set('google_client_secret', $request->input('google_client_secret'));
        if ($request->filled('google_calendar_id')) {
            SiteSetting::set('google_calendar_id', $request->input('google_calendar_id'));
        }

        return back()->with('status', 'Credenciales guardadas. Ahora conecta tu cuenta.');
    }

    public function authorize(GoogleCalendarService $gcal)
    {
        return redirect()->away($gcal->getAuthUrl());
    }

    public function callback(Request $request, GoogleCalendarService $gcal)
    {
        if ($request->has('code')) {
            $gcal->handleCallback($request->input('code'));

            return redirect()->route('admin.google-calendar.index')->with('status', 'Google Calendar conectado.');
        }

        return redirect()->route('admin.google-calendar.index')->with('error', 'No se pudo conectar.');
    }

    public function disconnect(GoogleCalendarService $gcal)
    {
        $gcal->disconnect();

        return back()->with('status', 'Desconectado de Google Calendar.');
    }
}
