<?php

namespace App\Livewire;

use App\Events\TestEvent;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

#[Title('Library')]
class Library extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $searchQuery = '';

    // Debounce the search query to avoid excessive updates
    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    #[Computed]
    public function mediaItems()
    {
        $query = Auth::user()->media()->with('genres');

        if (!empty($this->searchQuery)) {
            $query->search($this->searchQuery);
        }

        return $query->orderBy('created_at', 'desc')->paginate(6);
    }

    public function testReverb()
    {
        TestEvent::dispatch('Hello from Laravel');
    }

    public function clearSearch()
    {
        $this->searchQuery = '';
        $this->resetPage();
    }
}
