<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Media;
use Livewire\Attributes\On;

class ShowMedia extends Component
{
    public ?Media $media = null;

    #[On('show-media')]
    public function showMedia($mediaId)
    {
        $this->media = Media::with(['reviews', 'genres'])->findOrFail($mediaId);
    }

    public function deleteMedia()
    {
        $this->media->delete();
        $this->redirect(route('library'), navigate: true);
    }

    public function render()
    {
        return view('livewire.show-media', [
            'media' => $this->media,
        ]);
    }
}
