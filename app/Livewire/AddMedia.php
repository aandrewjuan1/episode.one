<?php

namespace App\Livewire;

use App\Livewire\Forms\MediaForm;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Media;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use App\Models\Genre;
use Livewire\Attributes\Computed;

class AddMedia extends Component
{
    use WithFileUploads;

    public MediaForm $form;

    #[Validate('required|image|max:1024', message: 'An error occurred, please try uploading an image again.')]
    public $image_path;

    public ?array $selectedGenres = [];

    #[Computed]
    public function genres()
    {
        return Genre::orderBy('name')->pluck('name')->toArray();
    }
    public function validateForm()
    {
        $this->form->validate(); // Validate form
    }

    public function addMedia()
    {
        $this->validate(); // Validate image path

        DB::beginTransaction();
        try {
            // Store the uploaded image
            $this->image_path = $this->image_path->store('images', 'public');

            // Create the media entry
            $media = Media::create([
                'user_id' => Auth::id(),
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
            $media->genres()->sync($genreIds);

            DB::commit();

            // Reset form
            $this->form->reset();
            $this->image_path = null;
            $this->selectedGenres = [];

            session()->flash('media-added', 'Media successfully added!');
            $this->redirect(route('library'), navigate: true);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding media: ' . $e->getMessage());
            session()->flash('media-added-error', 'An error occurred while adding media.');
        }
    }

    public function render()
    {
        return view('livewire.add-media', ["genres" => $this->genres()]);
    }
}
