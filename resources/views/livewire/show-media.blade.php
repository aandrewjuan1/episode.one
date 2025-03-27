<div class="relative flex flex-col overflow-hidden rounded-lg p-6">
    @if ($media)
        @if (str_starts_with($media->image_path, 'http'))
            <img src="{{ $media->image_path }}" class="h-full w-full rounded-lg shadow-lg" alt="{{ $media->title }}">
        @else
            <img src="{{ asset($media->image_path) }}" class="h-full w-full rounded-lg shadow-lg" alt="{{ $media->title }}">
        @endif

        <div class="mt-4 flex items-center justify-between">
            <h2 class="font-bold text-2xl sm:text-3xl md:text-4xl uppercase break-words dark:text-white line-clamp-2">
                {{ $media->title }}
            </h2>
            <flux:dropdown position="top" align="end">
                <flux:button icon="ellipsis-horizontal" />
                <flux:menu>
                    <flux:modal.trigger name="edit-media">
                        <flux:menu.item icon="pencil-square" wire:click="$dispatch('edit-media', { mediaId: {{ $media->id }} })">Edit</flux:menu.item>
                    </flux:modal.trigger>
                    <flux:modal.trigger name="delete-media">
                        <flux:menu.item icon="trash" variant="danger">Delete</flux:menu.item>
                    </flux:modal.trigger>
                </flux:menu>
            </flux:dropdown>
        </div>

        <p class="text-gray-700 dark:text-gray-300 text-sm sm:text-base uppercase mt-2"><strong>Type:</strong> {{ $media->type }}</p>
        <p class="text-gray-700 dark:text-gray-300 text-sm sm:text-base uppercase mt-1"><strong>Status:</strong> {{ $media->status }}</p>

        <div class="my-3 flex flex-wrap">
            <strong class="text-gray-800 dark:text-white mr-2">Genre:</strong>
            @if ($media->genres->isNotEmpty())
                @foreach ($media->genres as $genre)
                    <span class="inline-block lowercase font-medium text-gray-700 dark:text-gray-300 mr-2 mb-2 text-sm truncate max-w-full bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded">
                        {{ $genre->name }}
                    </span>
                @endforeach
            @else
                <span class="text-gray-500">No genres available</span>
            @endif
        </div>

        <p class="dark:text-gray-300 text-gray-600 mt-2 text-base leading-relaxed">{{ $media->overview }}</p>

        <div class="mt-6">
            <h3 class="text-xl font-semibold">Reviews</h3>
            @if ($media->reviews->isEmpty())
                <p class="text-gray-500">No reviews yet.</p>
            @else
                <div class="space-y-4 mt-3">
                    @foreach ($media->reviews as $review)
                        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                            <p class="text-lg font-semibold">⭐ {{ $review->rating }}/5</p>
                            <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <flux:modal name="edit-media">
            <livewire:edit-media />
        </flux:modal>
        <flux:modal name="delete-media" class="min-w-[22rem]">
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
