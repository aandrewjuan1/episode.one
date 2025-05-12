<?php

namespace App\Livewire;

use App\Events\TestEvent;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;

#[Title('Library')]
class Library extends Component
{
    #[Url(as: 'q')]
    public string $searchQuery = '';

    public int $perPage = 12;
    public int $page = 1;
    public bool $hasMorePages = true;

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->page++;
    }

    #[Computed]
    public function mediaItems()
    {
        $query = Auth::user()->media()->with('genres');

        if (!empty($this->searchQuery)) {
            $query->search($this->searchQuery);
        }

        $items = $query->orderBy('created_at', 'desc')
            ->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();

        $this->hasMorePages = $items->count() === $this->perPage;

        return $items;
    }

    public function resetPage()
    {
        $this->page = 1;
        $this->hasMorePages = true;
    }

    public function clearSearch()
    {
        $this->searchQuery = '';
        $this->resetPage();
    }
}
