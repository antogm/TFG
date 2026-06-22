@php
    $alertas = [
        'success' => 'bg-emerald-600 text-white',
        'error' => 'bg-red-600 text-white',
        'warning' => 'bg-amber-400 text-gray-900',
        'info' => 'bg-sky-600 text-white',
    ];
@endphp

@foreach ($alertas as $tipo => $clases)
    @if (session($tipo))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-4 right-4 z-50 flex min-h-[72px] w-[calc(100vw-2rem)] max-w-sm items-center rounded shadow-lg px-6 py-4 {{ $clases }}"
        >
            <div class="flex items-center gap-4">
                <span>{{ session($tipo) }}</span>
                <button type="button" @click="show = false">✕</button>
            </div>
        </div>
        @break
    @endif
@endforeach
