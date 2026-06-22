<div class="w-full rounded-xl border-l-4 border-sky-500 bg-white px-8 py-5 shadow-sm dark:bg-gray-800">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            {{ $numMensajesSinLeer > 0 ? __('views.unread_messages_count', ['count' => $numMensajesSinLeer]) : __('views.no_new_messages') }}
        </p>

        <a href="{{ route('conversations.index') }}"
            class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-sky-700">
            {{ __('nav.conversations') }}
        </a>
    </div>
</div>
