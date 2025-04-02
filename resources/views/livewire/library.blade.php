<div>
    <div class="grid grid-cols-1 min-[1120px]:grid-cols-3 gap-8">
        <div class="md:col-span-1">
            <flux:sidebar sticky>
                <div class="mb-8">
                    <flux:heading size="xl" level="1">{{ __('Library') }}</flux:heading>
                    <flux:subheading size="md" class="text-gray-500 dark:text-gray-400">
                        {{ __('View all your media collections') }}
                    </flux:subheading>
                </div>

                <flux:navlist>
                    <flux:navlist.item :href="route('library')" icon="book-open-text" wire:navigate
                        class="w-full hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md px-3 py-2">
                        {{ __('Media') }}
                    </flux:navlist.item>
                    <flux:navlist.item href="#" wire:navigate icon="heart"
                        class="w-full hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md px-3 py-2">
                        {{ __('Favourites') }}
                    </flux:navlist.item>
                </flux:navlist>
            </flux:sidebar>
        </div>

        <div class="md:col-span-2 pt-4 relative">
            @if (session()->has('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            @if (session()->has('error'))
                <x-alert type="error" :message="session('error')" />
            @endif
            <div class="flex space-x-4 items-start mb-4">
                <flux:input icon="magnifying-glass" placeholder="Search by media, genre, or type"
                    wire:model.live.debounce.300ms="searchQuery">
                    <x-slot name="iconTrailing">
                        @if (!empty($searchQuery))
                            <flux:button size="sm" wire:click="clearSearch()" variant="subtle" icon="x-mark"
                                class="-mr-1 rounded-2xl" />
                        @endif
                    </x-slot>
                </flux:input>
                <flux:modal.trigger name="add-media-modal">
                    <flux:button icon="plus" variant="primary">Add media</flux:button>
                </flux:modal.trigger>
            </div>

            <div class="flex justify-center">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse ($this->mediaItems as $media)
                        <flux:modal.trigger name="show-media-modal">
                            <a href="#" class="block" x-data
                                @click="$dispatch('show-review', { mediaId: {{ $media->id }} }); $dispatch('show-media', { mediaId: {{ $media->id }} })">
                                <x-media-card wire:key="{{ $media->id }}" :imagePath="$media->image_path" :title="$media->title"
                                    :type="$media->type" :genre="$media->genres->pluck('name')->toArray()" />
                            </a>
                        </flux:modal.trigger>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">{{ __('No media items found.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4">
                {{ $this->mediaItems->links() }}
            </div>

            <flux:modal name="show-media-modal">
                <livewire:show-media on-load />
            </flux:modal>
            <flux:modal name="add-media-modal">
                <livewire:add-media on-load />
            </flux:modal>
        </div>
    </div>
</div>
