<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Media;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Storage;

class ShowMedia extends Component
{
    public ?int $mediaId = null;

    #[On('show-media')]
    public function setMediaId(int $mediaId)
    {
        $this->mediaId = $mediaId;
    }

    #[Computed]
    public function media(): ?Media
    {
        if ($this->mediaId) {
            return Media::with(['reviews', 'genres'])->findOrFail($this->mediaId);
        }
        return null;
    }

    #[Computed]
    public function imageUrl(): ?string
    {
        if ($this->media) {
            return str_starts_with($this->media->image_path, 'http')
                ? $this->media->image_path
                : Storage::url($this->media->image_path);
        }
        return null;
    }

    #[Computed]
    public function formattedGenres(): string
    {
        if ($this->media && $this->media->genres->isNotEmpty()) {
            return $this->media->genres->pluck('name')->implode(', ');
        }
        return 'No genres available';
    }

    #[Computed]
    public function hasReviews(): bool
    {
        return $this->media && $this->media->reviews->isNotEmpty();
    }

    #[Computed]
    public function reviews()
    {
        return $this->media ? $this->media->reviews : collect();
    }

    public function deleteMedia()
    {
        if ($this->media) {
            $this->media->delete();
            session()->flash('media-deleted', 'Media successfully deleted!');
            $this->redirect(route('library'), navigate: true);
        }
    }

    public function placeholder()
    {
        return view('components.show-media-placeholder');
    }
}
