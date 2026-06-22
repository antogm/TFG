<tr
    data-fecha_registro="{{ $registroCorporal->fecha_registro?->format('Y-m-d') ?? '' }}"
    data-peso="{{ $registroCorporal->peso ?? '' }}"
    data-masa_muscular="{{ $registroCorporal->masa_muscular ?? '' }}"
    data-porcentaje_grasa="{{ $registroCorporal->porcentaje_grasa ?? '' }}"
    data-fecha_edicion="{{ $registroCorporal->fecha_edicion?->format('Y-m-d H:i:s') ?? '' }}"
>
    <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">
        {{ $registroCorporal->fecha_registro?->format('d/m/Y') ?? '-' }}
    </td>
    <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">
        {{ $registroCorporal->peso !== null ? $registroCorporal->peso . ' kg' : '-' }}
    </td>
    <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">
        {{ $registroCorporal->masa_muscular !== null ? $registroCorporal->masa_muscular . ' kg' : '-' }}
    </td>
    <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">
        {{ $registroCorporal->porcentaje_grasa !== null ? $registroCorporal->porcentaje_grasa . ' %' : '-' }}
    </td>
    <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">
        {{ $registroCorporal->fecha_edicion ? $registroCorporal->fecha_edicion->format('d/m/Y H:i') : '-' }}
    </td>

    @include('cliente._partials.historial.registroCorporal-actions', [
        'registroCorporal' => $registroCorporal,
        'esPropietarioHistorial' => $esPropietarioHistorial ?? $esPropietario ?? false,
    ])
</tr>
