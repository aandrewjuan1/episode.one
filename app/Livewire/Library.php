<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
class Library extends Component
{
    #[Url(as: 'q')]
    public string $searchQuery = '';

    public ?Collection $mediaItems;

    public function mount()
    {
        $this->loadMedia();
    }

    public function updatedSearchQuery()
    {
        $this->loadMedia();
    }

    public function loadMedia()
    {
        empty($this->searchQuery)
        ?
        $this->mediaItems = Media::where('user_id', Auth::id())
            ->with('genres')
            ->orderBy('created_at', 'desc')
            ->get()
        :
        $this->mediaItems = Media::search($this->searchQuery)
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function clearSearch()
    {
        $this->searchQuery = '';
        $this->loadMedia();
    }

    #[Title('Library')]
    public function render()
    {
        return view('livewire.library');
    }
}
