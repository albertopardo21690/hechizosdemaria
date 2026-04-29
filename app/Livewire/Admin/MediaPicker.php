<?php

namespace App\Livewire\Admin;

use App\Models\MediaFile;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class MediaPicker extends Component
{
    use WithFileUploads, WithPagination;

    public bool $open = false;

    public string $callbackField = '';

    public string $search = '';

    public string $folder = '';

    public string $tab = 'library'; // library | upload

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile[] */
    public $uploads = [];

    public string $uploadFolder = 'general';

    #[On('open-media-picker')]
    public function openPicker(string $field = ''): void
    {
        $this->callbackField = $field;
        $this->open = true;
        $this->tab = 'library';
        $this->search = '';
        $this->resetPage();
    }

    public function selectFile(int $id): void
    {
        $file = MediaFile::find($id);
        if (! $file) {
            return;
        }

        $this->dispatch('media-selected', url: $file->url(), field: $this->callbackField);
        $this->open = false;
    }

    public function uploadFiles(): void
    {
        $this->validate([
            'uploads' => 'required|array|max:20',
            'uploads.*' => 'file|max:10240',
        ]);

        $lastFile = null;
        $disk = \Illuminate\Support\Facades\Storage::disk('public');

        foreach ($this->uploads as $file) {
            $original = $file->getClientOriginalName();
            $name = pathinfo($original, PATHINFO_FILENAME);
            $ext = $file->getClientOriginalExtension();
            $filename = Str::slug($name).'-'.Str::random(6).'.'.$ext;
            $dir = "media/{$this->uploadFolder}";
            $path = "{$dir}/{$filename}";

            // Read dimensions before moving
            $width = null;
            $height = null;
            $mime = $file->getMimeType();
            $size = $file->getSize();
            $realPath = $file->getRealPath();

            if (str_starts_with($mime, 'image/') && $realPath) {
                try {
                    [$width, $height] = getimagesize($realPath);
                } catch (\Throwable) {
                }
            }

            // Store file with public visibility
            $disk->putFileAs($dir, $file, $filename, 'public');

            $lastFile = MediaFile::create([
                'name' => $name,
                'filename' => $filename,
                'path' => $path,
                'disk' => 'public',
                'mime_type' => $mime,
                'size' => $size,
                'width' => $width,
                'height' => $height,
                'folder' => $this->uploadFolder,
            ]);
        }

        $this->uploads = [];
        $this->tab = 'library';

        // Auto-select last uploaded if single file
        if ($lastFile && $this->callbackField) {
            $this->dispatch('media-selected', url: $lastFile->url(), field: $this->callbackField);
            $this->open = false;
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFolder(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = MediaFile::orderByDesc('created_at');

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }
        if ($this->folder) {
            $query->where('folder', $this->folder);
        }

        $files = $query->paginate(30);
        $folders = MediaFile::folders();

        return view('livewire.admin.media-picker', compact('files', 'folders'));
    }
}
