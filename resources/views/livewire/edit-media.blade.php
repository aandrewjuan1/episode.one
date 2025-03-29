<div>
    <form wire:submit="updateMedia">
        <flux:heading size="xl" class="mb-6">Edit Media</flux:heading>
        <div class="space-y-6">
            <flux:input
                label="Title"
                wire:model="form.title"
                placeholder="Enter title"
                class="max-w-sm"

            />

            <flux:select label="Type" wire:model="form.type" class="max-w-sm" >
                <flux:select.option value="Anime">Anime</flux:select.option>
                <flux:select.option value="Manga">Manga</flux:select.option>
                <flux:select.option value="Book">Book</flux:select.option>
                <flux:select.option value="Movie">Movie</flux:select.option>
            </flux:select>

            <flux:select label="Status" wire:model="form.status" class="max-w-sm"  >
                <flux:select.option value="Watching">Watching</flux:select.option>
                <flux:select.option value="Reading">Reading</flux:select.option>
                <flux:select.option value="Completed">Completed</flux:select.option>
                <flux:select.option value="On Hold">On Hold</flux:select.option>
                <flux:select.option value="Dropped">Dropped</flux:select.option>
                <flux:select.option value="Plan to Watch">Plan to Watch</flux:select.option>
            </flux:select>

            <flux:textarea
                label="Overview"
                wire:model="form.overview"
                placeholder="Enter a brief overview"
                rows="4"
                 >
            </flux:textarea>

            <!-- Show existing image preview -->
            @if ($image_path && !is_object($image_path))
                <div>
                    <p class="text-sm text-gray-600">Current Image:</p>
                    <img src="{{ asset('storage/' . $image_path) }}" class="w-32 h-32 object-cover rounded-md"/>
                </div>
            @endif

            <flux:input
                type="file"
                wire:model="image_path"
                accept="image/png, image/jpeg"
                label="Upload New Image (Optional)"
                class="max-w-lg"
            />

            <div class="flex justify-center">
                <flux:button variant="primary" type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove>Update</span>
                </flux:button>
            </div>
        </div>
    </form>
</div>
