<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use App\Livewire\Forms\MediaForm;
use Livewire\Attributes\On;

class EditMedia extends Component
{
    use WithFileUploads;

    public MediaForm $form;
    public ?Media $media = null;
    public $image_path;

    public function fillInputs($media)
    {
        $this->media = $media;

        // Prefill form with existing media data
        $this->form->fill([
            'title' => $media->title,
            'type' => $media->type,
            'status' => $media->status,
            'overview' => $media->overview,
        ]);

        $this->image_path = $this->media->image_path;
    }

    #[On('edit-media')]
    public function editMedia($mediaId)
    {
        $this->media = Media::where('id', $mediaId)->first();
        $this->fillInputs($this->media);
    }

    public function updateMedia()
    {
    // Validate everything **except** the image
        $this->validate([
            'form.title' => 'required|string|max:255',
            'form.type' => 'required|in:Manga,Anime,Book,Movie',
            'form.status' => 'nullable|in:Watching,Completed,On Hold,Dropped,Plan to Watch',
            'form.overview' => 'required|string',
        ]);

        // If a new image is uploaded, validate it separately
        if (is_object($this->image_path)) {
            $this->validate([
                'image_path' => 'image|max:1024', // Validate only if it's a file
            ]);
        }

        DB::beginTransaction();
        try {
            // Check if a new image was uploaded
            if (is_object($this->image_path)) {
                $this->image_path = $this->image_path->store('images', 'public');
            } else {
                // Keep existing image if no new file is uploaded
                $this->image_path = $this->media->image_path;
            }

            $this->media->update([
                'title' => $this->form->title,
                'type' => $this->form->type,
                'status' => $this->form->status,
                'overview' => $this->form->overview,
                'image_path' => $this->image_path,
            ]);

            session()->flash('success', 'Media updated successfully!');
            $this->redirect(route('library'), navigate: true);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating media: ' . $e->getMessage());
            session()->flash('error', 'Failed to update media. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.edit-media');
    }
}
