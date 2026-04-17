<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function serve(Request $request, string $token)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Enlace de descarga caducado o inválido.');
        }

        $path = $request->query('path');
        if (! $path || ! Storage::disk('local')->exists($path)) {
            abort(404, 'Archivo no encontrado.');
        }

        $mime = Storage::disk('local')->mimeType($path);
        $filename = basename($path);

        if (str_contains($mime, 'pdf')) {
            return response()->file(Storage::disk('local')->path($path), [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; filename="'.$filename.'"',
            ]);
        }

        return Storage::disk('local')->download($path, $filename);
    }

    public static function signedUrl(string $storagePath, int $minutesValid = 1440): string
    {
        return \URL::temporarySignedRoute(
            'download.serve',
            now()->addMinutes($minutesValid),
            ['token' => sha1($storagePath), 'path' => $storagePath]
        );
    }
}
