<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreValoracionEntrenadorRequest;
use App\Models\ClienteEntrenador;
use App\Models\Entrenador;
use Illuminate\Support\Facades\Auth;

class ClienteEntrenadorController extends Controller
{
    // Solo la ejecutan clientes
    public function solicitar(int $entrenadorId)
    {
        $clienteId = Auth::id();
        $entrenador = Entrenador::findOrFail($entrenadorId);

        if ($entrenador->bloquear_solicitudes_entrantes) {
            return redirect()
                ->route('entrenadores.index')
                ->with('error', __('views.trainer_not_accepting_requests'));
        }

        if (!ClienteEntrenador::clientePuedeSolicitar($clienteId)) {
            return redirect()
                ->route('entrenadores.index')
                ->with('error', __('views.already_have_pending_or_active_request'));
        }

        ClienteEntrenador::crearSolicitudPendiente($clienteId, $entrenadorId);

        return redirect()
            ->route('entrenadores.index')
            ->with('success', __('views.request_sent_success'));
    }

    // Solo la ejecutan entrenadores
    public function aceptar(int $userId){
        ClienteEntrenador::aceptarSolicitudPendiente(Auth::id(), $userId);

        return redirect()
            ->route('entrenador.dashboard')
            ->with('success', __('views.request_accepted_success'));
    }

    // Solo la ejecutan entrenadores
    public function rechazar(int $userId){
        ClienteEntrenador::rechazarSolicitudPendiente(Auth::id(), $userId);

        return redirect()
            ->route('entrenador.dashboard')
            ->with('success', __('views.request_rejected_success'));
    }

    // La ejecutan clientes o entrenadores
    public function cancelar(int $entrenador, ?int $cliente = null){
        $cliente ??= Auth::id();

        ClienteEntrenador::cancelarColaboracion($entrenador, $cliente);

        return back()
            ->with('success', __('views.collaboration_cancelled_success'));
    }

    // La ejecuta un cliente para valorar a su entrenador asignado
    public function valorar(StoreValoracionEntrenadorRequest $request, int $entrenador){
        $datos = $request->validated();

        $guardado = ClienteEntrenador::addValoracion($entrenador, Auth::id(), (float) $datos['valoracion']);

        if (! $guardado) {
            return redirect()
                ->route('entrenadores.show', $entrenador)
                ->with('error', __("views.review_save_error"));
        }

        return redirect()
            ->route('entrenadores.show', $entrenador)
            ->with('success', __("views.review_sent_success"));
    }

    // La ejecuta un cliente para eliminar la valoración a su entrenador asignado
    public function eliminarValoracion(int $entrenador){
        $eliminado = ClienteEntrenador::eliminarValoracion($entrenador, Auth::id());

        if (! $eliminado) {
            return redirect()
                ->route('entrenadores.show', $entrenador)
                ->with('error', __("views.review_delete_error"));
        }

        return redirect()
            ->route('entrenadores.show', $entrenador)
            ->with('success', __("views.review_deleted_success"));
    }

    public function gestionarSolicitudes(){
        $userId = Auth::user()->id;
        $solicitudes = ClienteEntrenador::getSolicitudesPendientes($userId);

        return view('entrenador.lista-solicitudes', compact('solicitudes'));
    }
}
