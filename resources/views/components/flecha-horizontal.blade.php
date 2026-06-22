@php
    $title = $title ?? '';
    $ariaLabel = $ariaLabel ?? $title;
    $direction = $direction ?? 'left';
    $dataAttributes = $dataAttributes ?? [];
    $path = $direction === 'right'
        ? 'M7.5 4.5 13 10l-5.5 5.5'
        : 'M12.5 4.5 7 10l5.5 5.5';
@endphp
<button type="button"
    @if($title) title="{{ $title }}" @endif
    @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
    @foreach($dataAttributes as $attribute => $value)
        {{ $attribute }}="{{ $value }}"
    @endforeach
    class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-300 transition hover:bg-slate-700 hover:text-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-slate-900 disabled:cursor-not-allowed disabled:text-slate-500 disabled:hover:bg-transparent disabled:hover:text-slate-500">
    <svg viewBox="0 0 20 20" fill="none" class="h-4 w-4" aria-hidden="true">
        <path d="{{ $path }}" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
    </svg>
</button>
