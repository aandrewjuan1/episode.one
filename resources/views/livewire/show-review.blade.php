<div x-data="{ showReviewForm: false, editingReviewId: null }" class="mt-6">
    <h3 class="text-lg font-semibold">Reviews</h3>

    {{-- Toggle review form --}}
    <flux:button @click="showReviewForm = !showReviewForm" variant="subtle" size="sm" class="mt-2">
        Add a Review
    </flux:button>

    {{-- Review form --}}
    <div x-show="showReviewForm" x-transition class="mt-4 p-4 bg-gray-200 dark:bg-gray-700 rounded-lg">
        <form wire:submit.prevent="addReview">
            <div class="space-y-6">
                <flux:select label="Rating" wire:model="rating" class="max-w-sm">
                    @for ($i = 1; $i <= 5; $i++)
                        <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
                    @endfor
                </flux:select>

                <flux:textarea label="Comment" wire:model="comment" placeholder="Type your comment..." rows="4">
                </flux:textarea>

                <div class="flex justify-between items-center">
                    <flux:button type="submit" variant="primary">
                        Submit Review
                    </flux:button>
                    <flux:button @click="showReviewForm = false" variant="danger">
                        Cancel
                    </flux:button>
                </div>
            </div>
        </form>
    </div>

    {{-- Display Reviews --}}
    @if ($this->reviews->isEmpty())
        <p class="text-gray-500 mt-4">No reviews yet.</p>
    @else
        <div class="space-y-4 mt-3">
            @foreach ($this->reviews as $review)
                <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                    @if ($editingReviewId === $review->id)
                        {{-- Editable Review Form --}}
                        <div class="mt-2">
                            <flux:select label="Rating" wire:model="editingRating" class="max-w-sm">
                                @for ($i = 1; $i <= 5; $i++)
                                    <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
                                @endfor
                            </flux:select>
                            <flux:textarea wire:model="editingComment" placeholder="This field is required..."
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:text-white">
                            </flux:textarea>
                            <div class="mt-2 flex gap-2">
                                <flux:button wire:click="updateReview" variant="primary" size="sm">
                                    Save
                                </flux:button>
                                <flux:button wire:click="cancelEdit" variant="danger" size="sm">
                                    Cancel
                                </flux:button>
                            </div>
                        </div>
                    @else
                        <div class="mt-2">
                            {{-- Non-Editable Review --}}
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-semibold">⭐ {{ $review->rating }}/5</p>
                                <div>
                                    @can('update', $review)
                                        <flux:button wire:click="edit({{ $review->id }})" size="xs" icon="pencil-square"
                                            variant="subtle" />
                                    @endcan
                                    @can('delete', $review)
                                        <flux:button wire:click="deleteReview({{ $review->id }})" size="xs" icon="x-circle"
                                            variant="subtle" />
                                    @endcan
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Reviewed by <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                            </p>
                            <p class="mt-1 text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
