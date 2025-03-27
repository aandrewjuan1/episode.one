<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use App\Livewire\Forms\MediaForm;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class EditMedia extends Component
{
    use WithFileUploads;

    public MediaForm $form;
    public ?Media $media = null;

    #[Validate('nullable|image|max:1024', message: 'An error occurred, please try uploading a valid image again.')]
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
        $this->validate();

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
            DB::commit();

            $this->form->reset();
            $this->image_path = null;

            session()->flash('media-updated', 'Media successfully updated!');
            $this->redirect(route('library'),navigate: true);


        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating media: ' . $e->getMessage());
            session()->flash('media-updated-error', 'An error occurred while updating media.');
        }
    }

    public function render()
    {
        return view('livewire.edit-media');
    }
}
