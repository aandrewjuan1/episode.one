<div>
    <form wire:submit="addMedia">
        <flux:heading size="xl" class="mb-6">Add media</flux:heading>
        <div class="space-y-6">
            <flux:input label="Title" wire:model="form.title" placeholder="Enter title" class="max-w-sm" required="true" />

            <flux:select label="Type" wire:model="form.type" class="max-w-sm" required="true">
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

            <flux:textarea label="Overview" wire:model="form.overview" placeholder="Enter a brief overview" rows="4" required="true"></flux:textarea>

            <flux:input type="file" wire:model="image_path" accept="image/png, image/jpeg" label="Image" class="max-w-lg" required="true"/>

            <div class="flex justify-center">
                <flux:button variant="primary" type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove>Add</span>
                </flux:button>
            </div>
        </div>
    </form>
</div>
