<div class="relative flex flex-col overflow-hidden p-6 bg-white dark:bg-zinc-800 transition-opacity duration-300" wire:loading.class="opacity-50">

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
                        <flux:menu.item icon="pencil-square" wire:click="$dispatch('edit-media', { mediaId: {{ $this->media->id }} })">Edit</flux:menu.item>
                    </flux:modal.trigger>

                    <flux:modal.trigger name="delete-media-modal">
                        <flux:menu.item icon="trash" variant="danger">Delete</flux:menu.item>
                    </flux:modal.trigger>
                </flux:menu>
            </flux:dropdown>
        </div>

        <div class="mt-3 flex flex-wrap justify-between text-sm sm:text-base text-gray-700 dark:text-gray-300 uppercase">
            <p>{{ $this->media->type }}</p>
            <p>{{ $this->media->status }}</p>
        </div>

        <div class="my-4 flex flex-wrap items-center gap-2">
            @if (!empty($this->genres) && is_array($this->genres))
                @foreach ($this->genres as $genre)
                    <span class="px-3 py-1 text-sm font-medium lowercase bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full">
                        {{ $genre }}
                    </span>
                @endforeach
            @else
                <span class="text-gray-500 dark:text-gray-400">None</span>
            @endif
        </div>

        <p class="mt-2 text-gray-600 dark:text-gray-300 text-base leading-relaxed">
            {{ $this->media->overview }}
        </p>

        <div class="mt-6">
            <h3 class="text-lg font-semibold">Reviews</h3>
            @if (!$this->hasReviews)
                <p class="text-gray-500">No reviews yet.</p>
            @else
                <div class="space-y-4 mt-3">
                    @foreach ($this->reviews as $review)
                        <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <p class="text-lg font-semibold">⭐ {{ $review->rating }}/5</p>
                            <p class="mt-1 text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <flux:modal name="edit-media-modal">
            <livewire:edit-media :media="$this->media" on-load/>
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
