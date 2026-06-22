<td class="px-4 py-4 text-center align-middle">
    <div class="flex flex-wrap justify-center gap-2">
        <a href="{{ route('registrocorporal.ver', $registroCorporal->id) }}"
            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800">
            {{ __('views.details') }}
        </a>

        @if($esPropietarioHistorial ?? false)
            <a href="{{ route('registrocorporal.edit', $registroCorporal->id) }}"
                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800">
                {{ __('views.edit') }}
            </a>

            <form method="POST" action="{{ route('registrocorporal.delete', $registroCorporal->id) }}"
                onsubmit="return confirm(@js(__('views.confirm_delete_body_record', ['date' => $registroCorporal->fecha_registro?->format('d/m/Y') ?? '-'])));">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="inline-flex items-center rounded-lg border border-red-300 bg-white px-3 py-2 text-sm font-medium text-red-700 transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-2 dark:border-red-800 dark:bg-gray-800 dark:text-red-300 dark:hover:bg-red-950/30 dark:focus:ring-offset-gray-800">
                    {{ __('views.delete') }}
                </button>
            </form>
        @endif
    </div>
</td>
