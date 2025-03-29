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

class AddMedia extends Component
{
    use WithFileUploads;

    public MediaForm $form;

    #[Validate('required|image|max:1024', message: 'An error occurred, please try uploading an image again.')]
    public $image_path;


    public function addMedia()
    {
        $this->form->validate();
    $this->validate();

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

            session()->flash('media-added', 'Media successfully added!');
            $this->redirect(route('library'),navigate: true);


        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding media: ' . $e->getMessage());
            session()->flash('media-added-error', 'An error occurred while adding media.');
        }
    }


    public function render()
    {
        return view('livewire.add-media');
    }
}
