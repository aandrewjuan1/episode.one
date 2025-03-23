<div class="p-4">
    <div class="flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-1/4">
            <div class="mb-6">
                <flux:heading size="xl" level="1">{{ __('Library') }}</flux:heading>
                <flux:subheading size="md">{{ __('View all your media collections') }}</flux:subheading>
            </div>
            <flux:navlist>
                <flux:navlist.item :href="route('library')" wire:navigate>{{ __('Media') }}</flux:navlist.item>
                <flux:navlist.item href="#" wire:navigate>{{ __('Favourites') }}</flux:navlist.item>
            </flux:navlist>
        </div>

        <div class="w-full md:w-3/4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-y-12">
                @foreach ($mediaItems as $media)
                    <x-media-card
                        :imagePath="$media->image_path"
                        :title="$media->title"
                        :type="$media->type"
                        :genre="$media->genres->pluck('name')->toArray()"
                    />
                @endforeach
            </div>
        </div>
    </div>
    <div>
</div>
