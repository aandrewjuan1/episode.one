<div>
    <form wire:submit="updateMedia">
        <flux:heading size="xl" class="mb-6">Edit Media</flux:heading>
        <div class="space-y-6">
            <flux:input
                label="Title"
                wire:model="form.title"
                placeholder="Enter title"
                class="max-w-sm"
                required
            />

            <flux:select label="Type" wire:model="form.type" class="max-w-sm" required>
                <option value="">-- Select Type --</option>
                <option value="Manga">Manga</option>
                <option value="Anime">Anime</option>
                <option value="Book">Book</option>
                <option value="Movie">Movie</option>
            </flux:select>

            <flux:select label="Status" wire:model="form.status" class="max-w-sm">
                <option value="">-- Select Status (Optional) --</option>
                <option value="Watching">Watching</option>
                <option value="Completed">Completed</option>
                <option value="On Hold">On Hold</option>
                <option value="Dropped">Dropped</option>
                <option value="Plan to Watch">Plan to Watch</option>
            </flux:select>

            <flux:textarea
                label="Overview"
                wire:model="form.overview"
                placeholder="Enter a brief overview"
                rows="4"
                required>
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
