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
                <div class="grid grid-cols-3 gap-1 sm:gap-2 md:gap-3"
                    x-data="{
                        observe() {
                            const observer = new IntersectionObserver((entries) => {
                                entries.forEach(entry => {
                                    if (entry.isIntersecting && @this.hasMorePages) {
                                        @this.loadMore()
                                    }
                                })
                            }, { threshold: 0.5 })

                            observer.observe(this.$el.lastElementChild)
                        }
                    }"
                    x-init="observe"
                    wire:loading.class="opacity-50">
                    @forelse ($this->mediaItems as $media)
                        <flux:modal.trigger name="show-media-modal">
                            <a href="#" class="block aspect-square relative group" x-data
                                @click="$dispatch('show-review', { mediaId: {{ $media->id }} }); $dispatch('show-media', { mediaId: {{ $media->id }} })">
                                <div class="w-full h-full relative">
                                    <img src="{{ $media->image_path }}" alt="{{ $media->title }}"
                                        class="w-full h-full object-cover" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-3">
                                        <h3 class="text-white font-bold text-lg drop-shadow-lg">
                                            {{ $media->title }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </flux:modal.trigger>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">{{ __('No media items found.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div wire:loading wire:target="loadMore" class="text-center py-4">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gray-300 border-t-primary"></div>
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
