@props(['type' => 'info', 'message'])

@php
    $color = match ($type) {
        'green' => 'text-md text-green-500',
        'red' => 'text-md text-red-500',
    };
@endphp

@if ($message)
    <div x-data="{ shown: true, timeout: null }"
         x-init="() => { clearTimeout(timeout); timeout = setTimeout(() => { shown = false }, 2000) }"
         x-show="shown"
         x-transition:leave.opacity.duration.1500ms
         style="display: none"
         class="{{ $color }} absolute -top-4">
        <p>{{ $message }}</p>
    </div>
@endif
