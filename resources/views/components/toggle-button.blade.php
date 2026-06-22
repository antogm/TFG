@php
    $activeColor = match ($color) {
        'rojo' => 'peer-checked:bg-red-600',
        'verde' => 'peer-checked:bg-green-600',
    };
@endphp

<label class="flex items-center justify-between gap-4">
    <span class="text-sm text-gray-700 dark:text-gray-300">
        {{ $slot }}
    </span>

    <span class="relative inline-flex items-center">
        <input name="{{ $name }}" type="hidden" value="0">
		<input name="{{ $name }}" type="checkbox" value="1" class="peer sr-only" @checked($checked)>
        <span
            class="h-6 w-11 rounded-full bg-gray-300 transition {{ $activeColor }} peer-focus:ring-2 peer-focus:ring-indigo-500 peer-focus:ring-offset-2 peer-focus:ring-offset-white dark:bg-gray-700 dark:peer-focus:ring-offset-gray-800"></span>
        <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-5"></span>
    </span>
</label>
