<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRutinaRequest;
use App\Models\Rutina;
use App\Models\User;
use App\Services\Rutina\RutinaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RutinaController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $entrenador = $user->entrenador;
        $rol = $user->rol;
        $search = trim((string) $request->get('search', ''));
        $rutinas = Rutina::getRutinas($entrenador->id, $search);
        $clientesSinRutina = $entrenador->clientesSinRutina();

        return view('rutinas.lista-rutinas', compact('rutinas', 'clientesSinRutina', 'rol'));
    }

    public function actual()
    {
        $user = Auth::user()->loadMissing([
            'asignacionRutinaActiva',
            'entrenadorAsignado.user',
        ]);

        if ($user->asignacionRutinaActiva) {
            return redirect()->route('rutinas.get', $user->asignacionRutinaActiva->rutina_id);
        }else{
            return view('rutinas.sin-rutina', ['entrenadorAsignado' => $user->entrenadorAsignado,]);
        }
    }

    public function get(int $rutina_id, RutinaService $rutinaService)
    {
        return view('rutinas.rutina_detalle', $rutinaService->getDatosRutina(
            $rutina_id,
            Auth::user()
        ));
    }

    public function create(){
        return view('rutinas.create_rutina');
    }

    public function edit(Rutina $rutina){
        $rutina->cargarRutina();
        $dayPlans = $rutina->getDayPlansFormulario();

        return view('rutinas.create_rutina', compact('rutina', 'dayPlans'));
    }

    public function store(StoreRutinaRequest $request){
        $validated = $request->validated();

        Rutina::createRutina($validated);

        return redirect()
            ->route('rutinas.lista-rutinas')
            ->with('success', __('views.routine_created_success'));
    }

    public function update(StoreRutinaRequest $request, Rutina $rutina){
        $validated = $request->validated();

        $rutina->updateRutina($validated);

        return redirect()
            ->route('rutinas.lista-rutinas')
            ->with('success', __('views.routine_updated_success'));
    }

    public function asignarCliente(Request $request, User $cliente)
    {
        $this->authorize('asignarRutina', $cliente);

        $data = $request->validate([
            'rutina_id' => ['required', 'integer'],
        ]);

        $asignada = Rutina::asignarCliente((int) $data['rutina_id'], $cliente->id, Auth::id());

        if ($asignada) {
            return redirect()
                ->route('usuario.progreso', $cliente->id)
                ->with('success', __('views.routine_assigned_success'));
        }else{
            return redirect()
                ->route('usuario.progreso', $cliente->id)
                ->with('error', __('views.routine_assigned_error'));
        }
    }

    public function desasignarCliente(User $cliente)
    {
        $this->authorize('desasignarRutina', $cliente);

        $desasignada = Rutina::desasignarCliente($cliente->id);

        if ($desasignada) {
            return redirect()
                ->route('usuario.progreso', $cliente->id)
                ->with('success', __('views.routine_unassigned_success'));
        }else{
            return redirect()
                ->route('usuario.progreso', $cliente->id)
                ->with('error', __('views.routine_unassigned_error'));
        }
    }

    public function asignarClientes(Request $request, int $rutina)
    {
        $data = $request->validate([
            'clientes' => ['nullable', 'array'],
            'clientes.*' => ['integer'],
        ]);

        $clientes = $data['clientes'] ?? [];
        Rutina::sincronizarClientesAsignados($rutina, Auth::id(), $clientes);

        return redirect()
            ->route('rutinas.lista-rutinas')
            ->with('success', __('views.routine_client_assignments_updated'));
    }

    public function delete(Rutina $rutina){
        $rutina->deleteRutina();

        return redirect()
            ->route('rutinas.lista-rutinas')
            ->with('success', __('views.routine_deleted_success'));
    }
}
