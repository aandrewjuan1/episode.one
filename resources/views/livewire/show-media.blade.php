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

        <div class="mt-2 flex gap-4">
            <!-- Media Type -->
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                <strong>Type:</strong> {{ $this->media->type }}
            </span>

            <!-- Media Status -->
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                <strong>Status:</strong> {{ $this->media->status }}
            </span>
        </div>

        <p class="mt-2 text-gray-600 dark:text-gray-300 text-base leading-relaxed">
            {{ $this->media->overview }}
        </p>

        <livewire:show-review :mediaId="$this->media->id" />

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
