<div class="flex flex-col overflow-hidden rounded-lg p-6">
    @if ($media)
        <!-- Image Section -->
        <div class="w-full h-80 overflow-hidden rounded-lg shadow-lg">
            @if (str_starts_with($media->image_path, 'http'))
                <img src="{{ $media->image_path }}" class="h-full w-full object-cover" alt="{{ $media->title }}">
            @else
                <img src="{{ asset($media->image_path) }}" class="h-full w-full object-cover" alt="{{ $media->title }}">
            @endif
        </div>

        <!-- Media Information -->
        <div class="mt-4">
            <h2 class="font-bold text-2xl sm:text-3xl md:text-4xl uppercase break-words dark:text-white line-clamp-2">{{ $media->title }}</h2>
            <p class="text-gray-700 dark:text-gray-300 text-sm sm:text-base uppercase mt-2"><strong>Type:</strong> {{ $media->type }}</p>
            <p class="text-gray-700 dark:text-gray-300 text-sm sm:text-base uppercase mt-1"><strong>Status:</strong> {{ $media->status }}</p>
        </div>

        <!-- Genre Section -->
        <div class="my-3 flex flex-wrap">
            <strong class="text-gray-800 dark:text-white mr-2">Genre:</strong>
            @if ($media->genres->isNotEmpty())
                @foreach ($media->genres as $genre)
                    <span class="inline-block lowercase font-medium text-gray-700 dark:text-gray-300 mr-2 mb-2 text-sm truncate max-w-full bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded">
                        {{ $genre->name }}
                    </span>
                @endforeach
            @else
                <span class="text-gray-500">No genres available</span>
            @endif
        </div>

        <!-- Overview Section -->
        <p class="dark:text-gray-300 text-gray-600 mt-2 text-base leading-relaxed">{{ $media->overview }}</p>

        <!-- Reviews Section -->
        <div class="mt-6">
            <h3 class="text-xl font-semibold">Reviews</h3>
            @if ($media->reviews->isEmpty())
                <p class="text-gray-500">No reviews yet.</p>
            @else
                <div class="space-y-4 mt-3">
                    @foreach ($media->reviews as $review)
                        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
                            <p class="text-lg font-semibold">⭐ {{ $review->rating }}/5</p>
                            <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
</div>
