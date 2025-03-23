<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Media;

class Library extends Component
{
    public $mediaItems;

    public function mount()
    {
        $this->loadMedia();
    }

    public function loadMedia()
    {
        // Eager load the genres to prevent N+1 queries
        $this->mediaItems = Media::where('user_id', Auth::id())
            ->with('genres') // Eager load the genres relationship
            ->get();
    }

    public function render()
    {
        return view('livewire.library');
    }
}
