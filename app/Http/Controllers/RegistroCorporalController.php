<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistroCorporalRequest;
use App\Http\Requests\UpdateRegistroCorporalRequest;
use App\Models\RegistroCorporal;
use App\Models\RegistroCorporalImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RegistroCorporalController extends Controller
{
    public function create(): View
    {
        $user = Auth::user();
        $ultimoRegistroCorporal = $user->ultimoRegistroCorporal;
        $registroCorporal = new RegistroCorporal();
        $registroCorporal->peso = $ultimoRegistroCorporal?->peso;
        $registroCorporal->masa_muscular = $ultimoRegistroCorporal?->masa_muscular;
        $registroCorporal->porcentaje_grasa = $ultimoRegistroCorporal?->porcentaje_grasa;
        $registroCorporal->fecha_registro = now();
        $registroCorporal->fecha_edicion = null;

        return view('cliente.registrocorporal-detalle', [
            'registroCorporal' => $registroCorporal,
            'esCreacion' => true,
            'esEdicion' => false,
            'puedeEditar' => true,
            'volverUrl' => route('cliente.dashboard'),
        ]);
    }

    public function store(StoreRegistroCorporalRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $registroCorporal = RegistroCorporal::crearRegistroCorporal($user, $request->validated());

        if (! $registroCorporal) {
            return back()
                ->withInput()
                ->with('error', __('registrocorporal.status_create_error'));
        }

        $registroCorporal->guardarImagenes($request->file('imagenes', []));

        return redirect()
            ->route('cliente.dashboard')
            ->with('success', __('registrocorporal.status_created'));
    }

    public function ver(RegistroCorporal $registroCorporal): View
    {
        $registroCorporal->load('imagenes');
        $puedeEditar = Auth::user()->can('update', $registroCorporal);

        return view('cliente.registrocorporal-detalle', [
            'registroCorporal' => $registroCorporal,
            'esCreacion' => false,
            'esEdicion' => false,
            'puedeEditar' => $puedeEditar,
            'volverUrl' => route('usuario.historial', $registroCorporal->usuario_id),
        ]);
    }

    public function edit(RegistroCorporal $registroCorporal): View
    {
        $registroCorporal->load('imagenes');

        return view('cliente.registrocorporal-detalle', [
            'registroCorporal' => $registroCorporal,
            'esCreacion' => false,
            'esEdicion' => true,
            'puedeEditar' => true,
            'volverUrl' => route('usuario.historial', $registroCorporal->usuario_id),
        ]);
    }

    public function update(UpdateRegistroCorporalRequest $request, RegistroCorporal $registroCorporal): RedirectResponse
    {
        $registroCorporal->actualizarConDatos($request->validated());
        $registroCorporal->guardarImagenes($request->file('imagenes', []));

        return redirect()
            ->route('usuario.historial', $registroCorporal->usuario_id)
            ->with('success', __('registrocorporal.status_updated'));
    }

    public function imagen(int $id_usuario, RegistroCorporalImage $imagen)
    {
        $registroCorporal = $imagen->registroCorporal;

        if (! $registroCorporal || (int) $registroCorporal->usuario_id !== $id_usuario) {
            abort(404);
        }

        $this->authorize('view', $registroCorporal);

        if (! Storage::disk('local')->exists($imagen->path)) {
            abort(404);
        }

        return Storage::disk('local')->response($imagen->path);
    }

    public function delete(RegistroCorporal $registroCorporal): RedirectResponse
    {
        $usuarioId = $registroCorporal->usuario_id;
        $registroCorporal->delete();

        return redirect()
            ->route('usuario.historial', $usuarioId)
            ->with('success', __('registrocorporal.status_deleted'));
    }
}
