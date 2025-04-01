<div x-data="{
    options: {{ json_encode($genres) }},
    selectedOptions: $wire.entangle('selectedGenres'),
    showError: false,
    filteredOptions() {
        return this.options.filter(option => !this.selectedOptions.includes(option));
    },
    selectOption(option) {
        if (option && !this.selectedOptions.includes(option)) {
            this.selectedOptions.push(option);
            this.showError = false; // Hide error when a genre is selected
        }
        this.$refs.genreSelect.value = '';
    },
    deselectOption(optionToRemove) {
        this.selectedOptions = this.selectedOptions.filter(option => option !== optionToRemove);
    },
    validateAndSubmit() {
        $wire.validateForm().then(() => { // Call Livewire validation first
            this.showError = this.selectedOptions.length === 0; // Only show genre error if empty after validation

            if (!this.showError) {
                $wire.updateMedia().then(() => {
                    $nextTick(() => {
                        showError = false; // Hide error after successful submission
                    });
                }).catch(() => {
                    $nextTick(() => {
                        this.showError = this.selectedOptions.length === 0;
                    });
                });
            }
        }).catch(() => {
            this.showError = false; // Don't show genre error yet if other fields have errors
        });
    }
}"
>
    <form @submit.prevent="validateAndSubmit()">
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

            <div class="flex flex-wrap gap-2 my-2">
                <template x-for="selectedOption in selectedOptions" :key="selectedOption">
                    <div class="inline-flex items-center rounded-full bg-gray-200 text-gray-800 text-sm py-1 px-3">
                        <span x-text="selectedOption"></span>
                        <button type="button" @click="deselectOption(selectedOption)" class="ml-2 text-red-500">✕</button>
                    </div>
                </template>
            </div>

            <flux:select placeholder="Choose genres..." label="Genres" class="max-w-sm" x-ref="genreSelect"
                @change="selectOption($event.target.value)">
                <template x-for="option in filteredOptions()" :key="option">
                    <option :value="option" x-text="option"></option>
                </template>
            </flux:select>

            <p class="mt-3 text-sm font-medium text-red-500 dark:text-red-400" x-show="showError">
                <flux:icon icon="exclamation-triangle" variant="mini" class="inline" />
                Please choose at least one genre.
            </p>

            <flux:input type="hidden" wire:model="selectedGenres" />

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
