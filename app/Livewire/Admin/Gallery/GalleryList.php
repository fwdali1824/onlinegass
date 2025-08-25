<?php

namespace App\Livewire\Admin\Gallery;

use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

#[Layout('components.layouts.admin')]
class GalleryList extends Component
{
    use WithFileUploads;

    public $image; // for individual upload
    public $uploadedImages = [];

    public function mount()
    {
        $this->loadImages();
    }

    public function loadImages()
    {
        $this->uploadedImages = Gallery::latest()->get();
    }

    public function uploadSingle($tmpFilePath)
    {
        $file = TemporaryUploadedFile::createFromLivewire($tmpFilePath);
        $path = $file->store('gallery', 'public');

        $gallery = Gallery::create([
            'image' => $path
        ]);

        // Insert new image at the top
        $this->uploadedImages->prepend($gallery);
    }

    public function delete($id)
    {
        $gallery = Gallery::findOrFail($id);
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        $this->loadImages();
    }

    public function render()
    {
        return view('livewire.admin.gallery.gallery-list');
    }
}
