<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\ClienteEntrenador;
use App\Models\Entrenador;
use App\Models\RegistroEntrenamiento;
use App\Models\User;
use App\Services\Cliente\ClienteProgresoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller {
    public function entrenadores(){
        $entrenadores = Entrenador::getEntrenadoresVisibles();
        $conocidos = Conversation::conocidos(Auth::id());
        $solicitudPendienteId = Auth::user()
            ->loadMissing('solicitudPendiente')
            ->solicitudPendiente?->entrenador_id;

        return view('cliente.lista-entrenadores', compact('entrenadores', 'solicitudPendienteId', 'conocidos'));
    }

    public function detalleEntrenador(Entrenador $entrenador){
        $usuarioActual = Auth::user();
        $entrenador->cargarUsuario();

        $esPropioEntrenador = (int) $usuarioActual->id === (int) $entrenador->id;
        $colaboracionActiva = null;

        if (! $esPropioEntrenador) {
            $colaboracionActiva = $usuarioActual->getRelacionActivaConEntrenador($entrenador->id);
        }

        $tieneRelacionActiva = $colaboracionActiva !== null;

        return view('cliente.entrenador-detalle', [
            'entrenador' => $entrenador,
            'usuarioActual' => $usuarioActual,
            'clientesActuales' => $entrenador->numeroClientesActuales(),
            'clientesAnteriores' => $entrenador->numeroClientesAnteriores(),
            'rutinasCreadas' => $entrenador->numeroRutinasCreadas(),
            'rating' => $entrenador->rating === null ? null : number_format(round((float) $entrenador->rating * 2) / 2, 1),
            'numeroValoraciones' => (int) $entrenador->numero_valoraciones,
            'puedeValorar' => $tieneRelacionActiva && $colaboracionActiva->valoracion === null,
            'valoracionCliente' => $colaboracionActiva?->valoracion,
            'puedeEnviarMensaje' => ! $esPropioEntrenador && ! $entrenador->user->bloquear_mensajes_desconocidos,
            'puedeSolicitarColaboracion' => ! $esPropioEntrenador
                && ClienteEntrenador::clientePuedeSolicitar($usuarioActual->id)
                && ! $entrenador->bloquear_solicitudes_entrantes,
        ]);
    }

    public function dashboard(ClienteProgresoService $progresoService){
        $user = Auth::user();

        return view('cliente.cliente-progreso', $progresoService->getDatosProgreso($user, $user));
    }

    public function panelProgreso(ClienteProgresoService $progresoService, $id = null){
        $user = User::findOrFail($id ?? Auth::id());

        $this->authorize('verProgreso', $user);

        return view('cliente.cliente-progreso', $progresoService->getDatosProgreso($user, Auth::user()));
    }

    public function historialCompleto(Request $request, $id = null){
        $id = $id ?? Auth::id();
        $user = User::findOrFail($id);
        $registrosCorporales = $user->getRegistrosCorporales();
        $registrosEntrenos = $user->getRegistrosEntrenamientos();
        $historialTabInicial = 'historial_corporal';

        if ($request->string('tab')->toString() === 'historial_entrenos') {
            $historialTabInicial = 'historial_entrenos';
        }

        $esPropietario = Auth::id() === $user->id;

        return view('cliente.cliente-historial', [
            'user' => $user,
            'registrosCorporales' => $registrosCorporales,
            'registrosEntrenos' => $registrosEntrenos,
            'historialTabInicial' => $historialTabInicial,
            'esPropietario' => $esPropietario,
            'puedeEditarHistorial' => $esPropietario,
        ]);
    }

    public function detalleEntreno(int $id, RegistroEntrenamiento $registroEntrenamiento)
    {
        $user = User::findOrFail($id);

        $this->authorize('verRegistroEntreno', [$user, $registroEntrenamiento]);

        $registroEntrenamiento->load([
            'asignacionRutina.rutina:id,nombre',
            'diaEntreno:id,nombre,orden',
            'registrosEjercicios.diaEntrenoEjercicio.ejercicio:id,nombre',
        ]);

        $puedeGestionarRegistroEntreno = Auth::user()->can('editarRegistroEntreno', [$user, $registroEntrenamiento]);

        return view('cliente.registro-entreno-detalle', compact(
            'user',
            'registroEntrenamiento',
            'puedeGestionarRegistroEntreno'
        ));
    }

}
