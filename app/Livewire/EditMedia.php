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
use App\Models\Genre;
use Livewire\Attributes\Computed;

class EditMedia extends Component
{
    use WithFileUploads;

    public MediaForm $form;
    public ?Media $media = null;

    #[Validate('image|max:1024')]
    public $image_path;
    public ?array $selectedGenres = [];

    public function fillInputs($media)
    {
        $this->media = $media;

        $this->form->fill([
            'title' => $media->title,
            'type' => $media->type,
            'status' => $media->status,
            'overview' => $media->overview,
        ]);

        $this->selectedGenres = $media->genres->pluck('name')->toArray();
        $this->image_path = $this->media->image_path;
    }

    #[Computed]
    public function genres()
    {
        return Genre::orderBy('name')->pluck('name')->toArray();
    }

    #[On('edit-media')]
    public function editMedia($mediaId)
    {
        $this->media = Media::where('id', $mediaId)->first();
        $this->fillInputs($this->media);
    }

    public function validateForm()
    {
        $this->form->validate(); // Validate form
    }
    public function updateMedia()
    {
        DB::beginTransaction();
        try {
            // Check if a new image was uploaded
            if (is_object($this->image_path)) {
                $this->validate();
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

            // Attach genres
            $genreIds = [];
            foreach ($this->selectedGenres as $genreName) {
                $genre = Genre::firstOrCreate(['name' => $genreName]);
                $genreIds[] = $genre->id;
            }
            $this->media->genres()->sync($genreIds);

            DB::commit();

            $this->form->reset();
            $this->image_path = null;

            session()->flash('success', 'Media successfully updated!');
            $this->redirect(route('library'), navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating media: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating media.');
        }
    }

    public function render()
    {
        return view('livewire.edit-media', ["genres" => $this->genres()]);
    }
}
