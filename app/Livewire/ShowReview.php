<?php

namespace App\Livewire;

use App\Models\Review;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ShowReview extends Component
{
    use AuthorizesRequests;

    public $showReviewForm = false;

    #[Validate('required|integer|min:1|max:5')]
    public ?int $rating = null;

    #[Validate('required|string|max:500')]
    public ?string $comment = '';

    public ?int $editingReviewId = null;

    #[Validate('required|integer|min:1|max:5')]
    public ?int $editingRating = null;

    #[Validate('required|string|max:500')]
    public ?string $editingComment = '';

    public ?int $mediaId = null;

    public function mount($mediaId)
    {
        $this->mediaId = $mediaId;
    }

    #[On('show-review')]
    public function setMediaId(int $mediaId)
    {
        $this->mediaId = $mediaId;
    }

    public function edit($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $this->authorize('update', $review);

        $this->editingReviewId = $reviewId;
        $this->editingComment = $review->comment;
        $this->editingRating = $review->rating;
    }

    public function updateReview()
    {
        $this->validateOnly('editingComment');
        $this->validateOnly('editingRating');

        DB::beginTransaction();
        try {
            $review = Review::findOrFail($this->editingReviewId);

            $this->authorize('update', $review);

            $review->update([
                'comment' => $this->editingComment,
                'rating' => $this->editingRating,
            ]);

            DB::commit();
            $this->dispatch('review-updated');
            $this->reset(['editingReviewId', 'editingComment', 'editingRating']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating review: ' . $e->getMessage());
        }
    }

    public function addReview()
    {
        $this->validateOnly('comment');
        $this->validateOnly('rating');

        DB::beginTransaction();
        try {
            Review::create([
                'user_id' => Auth::id(),
                'media_id' => $this->mediaId,
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);

            DB::commit();

            $this->showReviewForm = false;
            $this->reset(['rating', 'comment']);
            $this->dispatch('review-added');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding review: ' . $e->getMessage());
        }
    }

    #[Computed]
    public function reviews()
    {
        return Review::with(['user:id,name'])
            ->where('media_id', $this->mediaId)
            ->get();
    }

    public function deleteReview($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $this->authorize('delete', $review);

        $review->delete();
        $this->dispatch('review-deleted');

    }

    public function cancelEdit()
    {
        $this->reset(['editingReviewId', 'editingComment', 'editingRating']);
    }

    public function render()
    {
        // Debug session data
        Log::debug('Session data:', session()->all());
        return view('livewire.show-review');
    }
}
