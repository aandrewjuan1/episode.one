@props([
    'imagePath',
    'title',
    'type',
    'genre',
])

<div class="max-w-sm w-full bg-gray-100 dark:bg-zinc-800/50 shadow-lg p-4 sm:p-6 border border-gray-200 dark:border-zinc-700 flex flex-col">
    <div class="w-full h-50 sm:h-70"> {{-- Set a fixed height here --}}
        <img class="w-full h-full object-cover" src="{{ $imagePath }}" alt="{{ $title }}">
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

    <div class="mt-auto pt-2">
        <flux:button
            variant="ghost"
            href="#"
            icon:trailing="arrow-right"
            class="uppercase font-medium w-full sm:w-auto text-xs sm:text-sm"
        >
            More info
        </flux:button>
    </div>
</div>
