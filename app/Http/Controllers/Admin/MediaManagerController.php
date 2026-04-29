<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaManagerController extends Controller
{
    public function index(Request $request)
    {
        $folder = $request->get('folder', '');
        $search = $request->get('q', '');

        $query = MediaFile::orderByDesc('created_at');

        if ($folder) {
            $query->where('folder', $folder);
        }
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $files = $query->paginate(40);
        $folders = MediaFile::folders();

        return view('admin.media.index', compact('files', 'folders', 'folder', 'search'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array|max:20',
            'files.*' => 'file|max:10240',
            'folder' => 'nullable|string|max:50',
        ]);

        $folder = $request->input('folder', 'general');
        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $original = $file->getClientOriginalName();
            $name = pathinfo($original, PATHINFO_FILENAME);
            $ext = $file->getClientOriginalExtension();
            $filename = Str::slug($name).'-'.Str::random(6).'.'.$ext;
            $path = "media/{$folder}/{$filename}";

            Storage::disk('public')->putFileAs("media/{$folder}", $file, $filename);

            $width = null;
            $height = null;
            if (str_starts_with($file->getMimeType(), 'image/')) {
                try {
                    [$width, $height] = getimagesize($file->getRealPath());
                } catch (\Throwable) {
                }
            }

            $uploaded[] = MediaFile::create([
                'name' => $name,
                'filename' => $filename,
                'path' => $path,
                'disk' => 'public',
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'width' => $width,
                'height' => $height,
                'folder' => $folder,
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'files' => collect($uploaded)->map(fn ($f) => [
                    'id' => $f->id,
                    'url' => $f->url(),
                    'name' => $f->name,
                    'size' => $f->sizeForHumans(),
                ]),
            ]);
        }

        return back()->with('status', count($uploaded).' archivo(s) subido(s).');
    }

    public function update(Request $request, MediaFile $mediaFile)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'alt' => 'nullable|string|max:255',
            'folder' => 'nullable|string|max:50',
        ]);

        $mediaFile->update($data);

        return back()->with('status', 'Archivo actualizado.');
    }

    public function destroy(MediaFile $mediaFile)
    {
        Storage::disk($mediaFile->disk)->delete($mediaFile->path);
        $mediaFile->delete();

        return back()->with('status', 'Archivo eliminado.');
    }
}
