<?php

namespace App\Console\Commands;

use App\Models\MediaFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportBrandingToMedia extends Command
{
    protected $signature = 'media:import-branding';

    protected $description = 'Imports existing branding images into the media manager.';

    public function handle(): int
    {
        $source = public_path('images/branding');

        if (! File::isDirectory($source)) {
            $this->warn("No existe {$source}");
            return 1;
        }

        $files = File::files($source);
        $imported = 0;
        $skipped = 0;

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $ext = strtolower($file->getExtension());

            if (! in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'svg', 'gif'])) {
                continue;
            }

            // Skip if already imported
            if (MediaFile::where('filename', $filename)->where('folder', 'branding')->exists()) {
                $skipped++;
                continue;
            }

            // Copy to storage/app/public/media/branding
            $destPath = "media/branding/{$filename}";
            $disk = Storage::disk('public');
            if (! $disk->exists($destPath)) {
                $disk->put($destPath, File::get($file->getPathname()), 'public');
            }

            $width = null;
            $height = null;
            if (in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'gif'])) {
                try {
                    [$width, $height] = getimagesize($file->getPathname());
                } catch (\Throwable) {
                }
            }

            $mimeMap = [
                'png' => 'image/png',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'webp' => 'image/webp',
                'svg' => 'image/svg+xml',
                'gif' => 'image/gif',
            ];

            MediaFile::create([
                'name' => pathinfo($filename, PATHINFO_FILENAME),
                'filename' => $filename,
                'path' => $destPath,
                'disk' => 'public',
                'mime_type' => $mimeMap[$ext] ?? 'application/octet-stream',
                'size' => $file->getSize(),
                'width' => $width,
                'height' => $height,
                'folder' => 'branding',
            ]);

            $imported++;
            $this->line("  ✓ {$filename}");
        }

        $this->info("Importados: {$imported} · Omitidos: {$skipped}");

        return 0;
    }
}
