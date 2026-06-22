@props(['id'])

<form method="GET" action="{{ url()->current() }}" class="flex w-full gap-2 sm:flex-1">
    <x-text-input
        :id="$id"
        type="search"
        name="search"
        :value="request('search')"
        :placeholder="__('views.search_by_name')"
        class="w-full"
    />

    <x-primary-button>{{ __('views.search') }}</x-primary-button>
</form>
