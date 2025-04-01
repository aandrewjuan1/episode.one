<div class="relative flex flex-col overflow-hidden p-6 bg-white dark:bg-zinc-800 transition-opacity duration-300"
    wire:loading.class="opacity-50">
    @if ($this->media)

        @if ($this->imageUrl)
            <img src="{{ $this->imageUrl }}" class="w-full h-auto rounded-xl shadow" alt="{{ $this->media->title }}">
        @endif

        <div class="mt-4 flex items-center justify-between gap-2">
            <h2 class="font-bold text-xl sm:text-2xl md:text-3xl uppercase break-words dark:text-white line-clamp-2">
                {{ $this->media->title }}
            </h2>

            <flux:dropdown position="top" align="end">
                <flux:button icon="ellipsis-horizontal" />
                <flux:menu>
                    <flux:modal.trigger name="edit-media-modal">
                        <flux:menu.item icon="pencil-square"
                            wire:click="$dispatch('edit-media', { mediaId: {{ $this->media->id }} })">Edit
                        </flux:menu.item>
                    </flux:modal.trigger>

                    <flux:modal.trigger name="delete-media-modal">
                        <flux:menu.item icon="trash" variant="danger">Delete</flux:menu.item>
                    </flux:modal.trigger>
                </flux:menu>
            </flux:dropdown>
        </div>

        <p class="mt-2 text-gray-600 dark:text-gray-300 text-base leading-relaxed">
            {{ $this->media->overview }}
        </p>

        <div x-data="{ showReviewForm: false }" class="mt-6">
            <h3 class="text-lg font-semibold">Reviews</h3>

            {{-- Toggle review form --}}
            <flux:button @click="showReviewForm = !showReviewForm" variant="subtle" size="sm" class="mt-2">
                Add a Review
            </flux:button>

            {{-- Review form (Alpine.js controlled) --}}
            <div x-show="showReviewForm" x-transition class="mt-4 p-4 bg-gray-200 dark:bg-gray-700 rounded-lg">
                <form wire:submit="addReview">
                    <div class="space-y-6">
                        <flux:select label="Rating" wire:model="rating" class="max-w-sm">
                            <flux:select.option value="1">1</flux:select.option>
                            <flux:select.option value="2">2</flux:select.option>
                            <flux:select.option value="3">3</flux:select.option>
                            <flux:select.option value="4">4</flux:select.option>
                            <flux:select.option value="5">5</flux:select.option>
                        </flux:select>

                        <flux:textarea label="Comment" wire:model="comment" placeholder="Type your comment..."
                            rows="4">
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
            <livewire:show-review :mediaId="$this->media->id" />
        </div>

        <flux:modal name="edit-media-modal">
            <livewire:edit-media on-load />
        </flux:modal>

        <flux:modal name="delete-media-modal" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete media?</flux:heading>
                    <flux:text class="mt-2">
                        <p>You're about to delete this media.</p>
                        <p>This action cannot be reversed.</p>
                    </flux:text>
                </div>

                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="danger" wire:click="deleteMedia()">Delete media</flux:button>
                </div>
            </div>
        </flux:modal>

    @endif
</div>
