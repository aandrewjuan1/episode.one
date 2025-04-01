<div>
    {{-- Display Reviews --}}
    @if ($this->reviews->isEmpty())
        <p class="text-gray-500 mt-4">No reviews yet.</p>
    @else
        <div class="space-y-4 mt-3">
            @foreach ($this->reviews as $review)
                <div x-data="{ editMode: false, editedComment: '{{ $review->comment }}', editedRating: '{{ $review->rating }}' }" class="p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">

                    <div class="flex justify-between items-center">
                        <template x-if="!editMode">
                            <p class="text-lg font-semibold">⭐ {{ $review->rating }}/5</p>
                        </template>

                        <template x-if="editMode">
                            <flux:select label="Rating" x-model="editedRating" class="max-w-sm">
                                <flux:select.option value="1">1</flux:select.option>
                                <flux:select.option value="2">2</flux:select.option>
                                <flux:select.option value="3">3</flux:select.option>
                                <flux:select.option value="4">4</flux:select.option>
                                <flux:select.option value="5">5</flux:select.option>
                            </flux:select>
                        </template>

                        @can('edit', $review)
                            <div>
                                <flux:button @click="editMode = !editMode" size="xs" icon="pencil-square"
                                    variant="subtle" />
                                <flux:button @click="$wire.deleteReview({{ $review->id }})" size="xs" icon="x-circle"
                                    variant="subtle" />
                            </div>
                        @endcan
                    </div>

                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Reviewed by <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                    </p>

                    <!-- Editable comment -->
                    <template x-if="editMode">
                        <div class="mt-2">
                            <flux:textarea x-model="editedComment"
                                class="w-full p-2 rounded border dark:bg-gray-700 dark:text-white"></flux:textarea>
                            <div class="mt-2 flex gap-2">
                                <flux:button
                                    @click="$wire.updateReview({{ $review->id }}, editedComment, editedRating); editMode = false"
                                    variant="primary" size="sm">
                                    Save
                                </flux:button>
                                <flux:button @click="editMode = false" variant="danger" size="sm">
                                    Cancel
                                </flux:button>
                            </div>
                        </div>
                    </template>

                    <!-- Regular comment display -->
                    <p x-show="!editMode" class="mt-1 text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
