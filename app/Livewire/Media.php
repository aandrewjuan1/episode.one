<?php

namespace App\Livewire;

use App\Livewire\Forms\MediaForm;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Media as MediaModel;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Media extends Component
{
    use WithFileUploads;
    public MediaForm $form;

    public function addMedia()
    {
        $this->form->validate();

        DB::beginTransaction();
        try {

            $this->form->image_path = $this->form->image_path->store('images', 'public');

            MediaModel::create([
                'user_id' => Auth::id(), // Add the authenticated user's ID
                'title' => $this->form->title,
                'type' => $this->form->type,
                'status' => $this->form->status,
                'overview' => $this->form->overview,
                'image_path' => $this->form->image_path,
            ]);

            $this->form->reset();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error adding media: ' . $e->getMessage());
            session()->flash('error', 'Failed to add media. Please try again.');
        }

        session()->flash('success', 'Media added successfully!');
    }
    public function render()
    {
        return view('livewire.media');
    }
}
