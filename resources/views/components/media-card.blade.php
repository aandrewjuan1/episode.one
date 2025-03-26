@props([
    'imagePath',
    'title',
    'type',
    'genre',
    'class' => ''
])

<div {{ $attributes->merge(['class' => "h-full max-w-sm w-full bg-gray-100 dark:bg-zinc-800/50 shadow-lg p-4 sm:p-6 border-2 hover:border-black dark:hover:border-gray-300 flex flex-col overflow-hidden transform transition-transform hover:scale-105 {$class}"]) }}>
    <div class="w-full h-80">
        @if (str_starts_with($imagePath, 'http'))
            <img src="{{ $imagePath }}" class="h-full w-full object-cover" alt="{{ $title }}">
        @else
            <img src="{{ asset($imagePath) }}" class="h-full w-full object-cover" alt="{{ $title }}">
        @endif
    </div>

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mt-2 gap-2">
        <h2 class="font-bold text-xl sm:text-2xl md:text-3xl uppercase break-words dark:text-white line-clamp-2">{{ $title }}</h2>
        <p class="text-gray-700 dark:text-gray-300 text-xs sm:text-sm uppercase">{{ $type }}</p>
    </div>

    <div class="my-2 flex flex-wrap">
        @foreach ($genre as $singleGenre)
            <span class="inline-block lowercase font-medium text-gray-700 dark:text-gray-300 mr-2 mb-2 text-sm truncate max-w-full">
                {{ $singleGenre }}
            </span>
        @endforeach
    </div>
</div>
