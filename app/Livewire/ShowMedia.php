<?php

namespace App\Livewire;

use App\Models\Media;
use App\Models\Review;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShowMedia extends Component
{
    public ?int $mediaId = null;

    #[Validate('required|integer|min:1|max:5')]
    public ?int $rating = null;
    #[Validate('required|string|max:500')]
    public ?string $comment = '';

    public function addReview()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            Review::create([
                'user_id' => Auth::id(),
                'media_id' => $this->mediaId,
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);

            DB::commit();

            $this->reset(['rating', 'comment']);
            session()->flash('success', 'Review added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding review: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while adding the review.');
        }
    }

    #[On('show-media')]
    public function setMediaId(int $mediaId)
    {
        $this->mediaId = $mediaId;
        $this->dispatch('show-review', mediaId: $this->media->id);
    }

    #[Computed]
    public function media(): ?Media
    {
        if ($this->mediaId) {
            return Media::with('genres:name')->findOrFail($this->mediaId);
        }
        return null;
    }

    #[Computed]
    public function reviews()
    {
        return Media::find($this->mediaId)?->reviews()
            ->with(['user:id,name'])
            ->get();
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
    public function genres(): array | null
    {
        return $this->media?->genres->isNotEmpty() ? $this->media->genres->pluck('name')->toArray() : null;
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
