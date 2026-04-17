<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\SiteSetting;
use Google\Client as GoogleClient;
use Google\Service\Calendar as GoogleCalendar;
use Google\Service\Calendar\Event as GoogleEvent;
use Google\Service\Calendar\EventDateTime;

class GoogleCalendarService
{
    protected ?GoogleClient $client = null;

    public function isConfigured(): bool
    {
        return SiteSetting::get('google_client_id')
            && SiteSetting::get('google_client_secret')
            && SiteSetting::get('google_calendar_token');
    }

    public function getClient(): GoogleClient
    {
        if ($this->client) {
            return $this->client;
        }

        $client = new GoogleClient();
        $client->setClientId(SiteSetting::get('google_client_id', ''));
        $client->setClientSecret(SiteSetting::get('google_client_secret', ''));
        $client->setRedirectUri(route('admin.google-calendar.callback'));
        $client->addScope(GoogleCalendar::CALENDAR_EVENTS);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        $token = json_decode(SiteSetting::get('google_calendar_token', '{}'), true);
        if ($token) {
            $client->setAccessToken($token);
            if ($client->isAccessTokenExpired() && $client->getRefreshToken()) {
                $newToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                SiteSetting::set('google_calendar_token', json_encode($newToken));
            }
        }

        $this->client = $client;

        return $client;
    }

    public function getAuthUrl(): string
    {
        return $this->getClient()->createAuthUrl();
    }

    public function handleCallback(string $code): void
    {
        $client = $this->getClient();
        $token = $client->fetchAccessTokenWithAuthCode($code);
        SiteSetting::set('google_calendar_token', json_encode($token));
    }

    public function disconnect(): void
    {
        SiteSetting::set('google_calendar_token', null);
    }

    public function syncBooking(Booking $booking): ?string
    {
        if (! $this->isConfigured()) {
            return null;
        }

        $calendar = new GoogleCalendar($this->getClient());
        $calendarId = SiteSetting::get('google_calendar_id', 'primary');

        $startDate = $booking->preferred_date ?? $booking->created_at;
        $timeMap = ['mañana' => '10:00', 'tarde' => '16:00', 'noche' => '20:00'];
        $startTime = $timeMap[$booking->preferred_time ?? ''] ?? '12:00';
        $duration = $booking->service?->duration_minutes ?? 60;

        $start = $startDate->format('Y-m-d').'T'.$startTime.':00';
        $end = $startDate->copy()->setTimeFromTimeString($startTime)->addMinutes($duration)->format('Y-m-d\TH:i:s');

        $event = new GoogleEvent([
            'summary' => '🌙 '.$booking->service?->name.' — '.$booking->customer_name,
            'description' => "Reserva #{$booking->reference}\n"
                ."Cliente: {$booking->customer_name}\n"
                ."Email: {$booking->customer_email}\n"
                ."Teléfono: {$booking->customer_phone}\n"
                ."Método: {$booking->delivery_method}\n"
                .($booking->customer_notes ? "Notas: {$booking->customer_notes}\n" : '')
                ."\nAdmin: ".route('admin.bookings.show', $booking),
            'start' => new EventDateTime(['dateTime' => $start, 'timeZone' => 'Europe/Madrid']),
            'end' => new EventDateTime(['dateTime' => $end, 'timeZone' => 'Europe/Madrid']),
            'colorId' => '6',
        ]);

        if ($booking->google_calendar_event_id) {
            $result = $calendar->events->update($calendarId, $booking->google_calendar_event_id, $event);
        } else {
            $result = $calendar->events->insert($calendarId, $event);
        }

        $eventId = $result->getId();
        $booking->update(['google_calendar_event_id' => $eventId]);

        return $eventId;
    }

    public function deleteEvent(Booking $booking): void
    {
        if (! $this->isConfigured() || ! $booking->google_calendar_event_id) {
            return;
        }

        $calendar = new GoogleCalendar($this->getClient());
        $calendarId = SiteSetting::get('google_calendar_id', 'primary');

        try {
            $calendar->events->delete($calendarId, $booking->google_calendar_event_id);
            $booking->update(['google_calendar_event_id' => null]);
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
