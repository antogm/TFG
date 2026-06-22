<div class="w-full sm:flex-1">
    <input
        id="{{ $id ?? 'list-search' }}"
        type="search"
        data-list-search="{{ $target ?? '' }}"
        placeholder="{{ $placeholder ?? __('views.search_by_name') }}"
        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
    >
</div>
