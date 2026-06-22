<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistroEntrenamientoRequest;
use App\Http\Requests\UpdateRegistroEntrenamientoRequest;
use App\Models\RegistroEntrenamiento;
use App\Models\User;
use App\Services\Rutina\RutinaService;
use Illuminate\Support\Facades\Auth;

class RegistroEntrenamientoController extends Controller
{
    public function create(int $rutina, RutinaService $rutinaService)
    {
        $usuario = Auth::user();

        $this->authorize('registrarEntreno', [$usuario, $rutina]);

        $asignacionRutina = $usuario->asignacionRutinaActiva()
            ->with('rutinaConDetalle')
            ->firstOrFail();

        $rutina = $asignacionRutina->rutinaConDetalle;

        return view('rutinas.rutina_detalle', $rutinaService->getDatosCreateRegistro($rutina));
    }

    public function store(StoreRegistroEntrenamientoRequest $request, int $rutina)
    {
        $usuario = Auth::user();
        $asignacionRutina = $usuario->asignacionRutinaActiva()
            ->with('rutinaConDetalle')
            ->firstOrFail();

        $rutina = $asignacionRutina->rutinaConDetalle;

        $data = $request->validated();
        $diaId = (int) $data['dia_activo_id'];

        $this->authorize('registrarDiaEntreno', [$usuario, (int) $rutina->id, $diaId]);

        $diaEntreno = $rutina->diasEntreno->firstWhere('id', $diaId);
        $registroEjercicios = $data['registro'][$diaId] ?? [];
        $resumenDia = $data['registro_resumen'][$diaId] ?? [];

        RegistroEntrenamiento::createRegistroEntrenamiento(
            $asignacionRutina,
            $diaEntreno,
            $registroEjercicios,
            $resumenDia,
            $usuario->id
        );

        return redirect()
            ->route('usuario.historial', ['id' => $usuario->id, 'tab' => 'historial_entrenos'])
            ->with('success', __('views.workout_logged_success'));
    }

    public function edit(int $id, RegistroEntrenamiento $registroEntrenamiento, RutinaService $rutinaService)
    {
        $user = User::findOrFail($id);

        $this->authorize('editarRegistroEntreno', [$user, $registroEntrenamiento]);

        $registroEntrenamiento->load([
            'diaEntreno',
            'registrosEjercicios',
        ]);

        $asignacionRutina = $registroEntrenamiento->asignacionRutina()->firstOrFail();
        $rutina = $asignacionRutina->rutina()->conDetalle()->firstOrFail();

        return view('rutinas.rutina_detalle', $rutinaService->getDatosEditRegistro(
            $rutina,
            $registroEntrenamiento
        ));
    }

    public function update(UpdateRegistroEntrenamientoRequest $request, int $id, RegistroEntrenamiento $registroEntrenamiento)
    {
        $user = User::findOrFail($id);

        $this->authorize('editarRegistroEntreno', [$user, $registroEntrenamiento]);

        $data = $request->validated();
        $diaId = (int) $data['dia_activo_id'];
        $diaEntreno = $registroEntrenamiento->diaEntreno()
            ->with('ejerciciosProgramados')
            ->firstOrFail();

        if ((int) $diaEntreno->id !== $diaId) {
            abort(422);
        }

        $registroEjercicios = $data['registro'][$diaId] ?? [];
        $resumenDia = $data['registro_resumen'][$diaId] ?? [];

        $registroEntrenamiento->updateRegistroEntrenamiento($diaEntreno, $registroEjercicios, $resumenDia);

        return redirect()
            ->route('usuario.historial', ['id' => $user->id, 'tab' => 'historial_entrenos'])
            ->with('success', __('views.workout_record_updated_success'));
    }

    public function delete(int $id, RegistroEntrenamiento $registroEntrenamiento)
    {
        $user = User::findOrFail($id);

        $this->authorize('eliminarRegistroEntreno', [$user, $registroEntrenamiento]);

        $registroEntrenamiento->delete();

        return redirect()
            ->route('usuario.historial', ['id' => $user->id, 'tab' => 'historial_entrenos'])
            ->with('success', __('views.workout_record_deleted_success'));
    }

}
