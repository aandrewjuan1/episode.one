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
        }
        this.$refs.genreSelect.value = ''; // Reset the select
    },
    deselectOption(optionToRemove) {
        this.selectedOptions = this.selectedOptions.filter(option => option !== optionToRemove);
    }
}">

    <div class="flex flex-wrap gap-2 my-2">
        <template x-for="selectedOption in selectedOptions" :key="selectedOption">
            <div class="inline-flex items-center rounded-full bg-gray-200 text-gray-800 text-sm py-1 px-3">
                <span x-text="selectedOption"></span>
                <button type="button" @click="deselectOption(selectedOption)" class="ml-2 text-red-500">✕</button>
            </div>
        </template>
    </div>

    <flux:select placeholder="Choose genres..." label="Genres" class="max-w-sm" x-ref="genreSelect" @change="selectOption($event.target.value)">
        <template x-for="option in filteredOptions()" :key="option">
            <option :value="option" x-text="option"></option>
        </template>
    </flux:select>

    <p class="mt-3 text-sm font-medium text-red-500 dark:text-red-400" x-show="showError && selectedOptions.length === 0">
        <flux:icon icon="exclamation-triangle" variant="mini" class="inline" />
        Please choose at least one genre.
    </p>

    <flux:input type="hidden" wire:model="selectedGenres" />
</div>
