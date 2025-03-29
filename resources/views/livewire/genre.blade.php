@props([
    'genres',
])
<div x-data="{
    options: {{ json_encode($genres) }},
    selectedOptions: [],
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
            <span class="inline-flex items-center rounded-full bg-gray-200 text-gray-800 text-sm py-0.5 px-2">
                <span x-text="selectedOption"></span>
                <button
                    type="button"
                    @click="deselectOption(selectedOption)"
                    class="ml-1.5 -mr-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                >
                    <span class="sr-only">Remove option</span>
                    <svg class="h-3 w-3" stroke="currentColor" fill="none" viewBox="0 0 8 8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-width="1.5" d="m1 1 6 6m0-6L1 7"/>
                    </svg>
                </button>
            </span>
        </template>
    </div>

    <flux:select label="Genres" class="max-w-sm" required="true" x-ref="genreSelect" @change="selectOption($event.target.value)">
        <option value="">-- Select Genres --</option>
        <template x-for="option in filteredOptions()" :key="option">
            <option :value="option" x-text="option"></option>
        </template>
    </flux:select>

    <input type="hidden" name="selected_genres" :value="JSON.stringify(selectedOptions)">
</div>
