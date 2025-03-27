<?php

namespace App\Livewire;

use App\Livewire\Forms\MediaForm;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Media;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class AddMedia extends Component
{
    use WithFileUploads;

    public MediaForm $form;

    public $image_path;

    public function addMedia()
    {
        // Validate all other form fields
        $this->validate();

        // Separate validation for the image (making it required)
        $this->validate([
            'image_path' => 'required|image|max:1024', // Must be an image and max 1MB
        ]);

        DB::beginTransaction();
        try {
            // Store the uploaded image
            $this->image_path = $this->image_path->store('images', 'public');

            Media::create([
                'user_id' => Auth::id(),
                'title' => $this->form->title,
                'type' => $this->form->type,
                'status' => $this->form->status,
                'overview' => $this->form->overview,
                'image_path' => $this->image_path,
            ]);

            DB::commit();

            $this->form->reset();
            $this->image_path = null;
            $this->dispatch('media-added');
            $this->dispatch('modal-close', ['name' => 'add-media-modal']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding media: ' . $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.add-media');
    }
}
