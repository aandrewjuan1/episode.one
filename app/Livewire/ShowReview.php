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

class ShowReview extends Component
{

    #[Validate('required|integer|min:1|max:5')]
    public ?int $rating = null;
    #[Validate('required|string|max:500')]
    public ?string $comment = '';

    public ?int $mediaId = null;

    #[On('show-review')]
    public function setMediaId(int $mediaId)
    {
        $this->mediaId = $mediaId;
    }

    #[Computed]
    public function reviews()
    {
        return Review::with(['user:id,name'])
            ->where('media_id', $this->mediaId)
            ->get();
    }

    public function updateReview($reviewId, $newComment, $newRating)
    {
        $this->rating = $newRating;
        $this->comment = $newComment;

        $this->validate();

        DB::beginTransaction();
        try {
            $review = Review::findOrFail($reviewId);
            $this->authorize('update', $review);

            // Update the review with validated data
            $review->update([
                'comment' => $this->comment,
                'rating' => $this->rating,
            ]);

            DB::commit();
            $this->reset(['rating', 'comment']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating review: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the review.');
        }
    }


    public function deleteReview($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        $this->authorize('delete', $review);

        $review->delete();

        session()->flash('message', 'Review deleted successfully.');
    }


    public function render()
    {
        return view('livewire.show-review');
    }
}
