<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEjercicioRequest;
use App\Models\Ejercicio;
use App\Models\GrupoMuscular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EjercicioController extends Controller
{
    public function index(Request $request){
        $search = trim((string) $request->query('search', ''));
        $ejercicios = Ejercicio::getEjerciciosPaginados($search);
        $rol = Auth::user()->rol;

        return view('ejercicios.lista-ejercicios', compact('ejercicios', 'rol'));
    }

    public function getEjerciciosAPI()
    {
        $ejercicios = Ejercicio::getEjercicios()
            ->sortBy('nombre')
            ->values()
            ->map(fn ($ejercicio) => [
                'id' => $ejercicio->id,
                'name' => $ejercicio->nombre,
                'group' => $ejercicio->gruposMusculares->pluck('nombre')->join(', ') ?: __('views.no_muscle_groups_short'),
                'image' => $ejercicio->imagen ? Storage::url($ejercicio->imagen) : null,
            ]);

        return response()->json($ejercicios);
    }

    public function edit(Ejercicio $ejercicio){
        $ejercicio->cargarGruposMusculares();
        $gruposMusculares = GrupoMuscular::getGruposMusculares();
        $gruposPrincipales = $gruposMusculares->whereNull('parent_id')->values();
        $subgruposPorPadre = $gruposMusculares
            ->whereNotNull('parent_id')
            ->groupBy('parent_id')
            ->map(function ($subgrupos) {
                return $subgrupos->values();
            })
            ->all();

        return view('ejercicios.create_ejercicio', compact('ejercicio', 'gruposPrincipales', 'subgruposPorPadre'));
    }

    public function create(){
        $gruposMusculares = GrupoMuscular::getGruposMusculares();
        $gruposPrincipales = $gruposMusculares->whereNull('parent_id')->values();
        $subgruposPorPadre = $gruposMusculares
            ->whereNotNull('parent_id')
            ->groupBy('parent_id')
            ->map(function ($subgrupos) {
                return $subgrupos->values();
            })
            ->all();

        return view('ejercicios.create_ejercicio', compact('gruposPrincipales', 'subgruposPorPadre'));
    }

    public function store(StoreEjercicioRequest $request){
        $validated = $request->validated();
        $grupoMuscularIds = $validated['grupos_musculares'] ?? [];

        unset($validated['grupos_musculares']);

        if ($request->hasFile('imagen')){
            $validated['imagen'] = $request->file('imagen')->store('ejercicios', 'public');
        }

        $ejercicio = Ejercicio::createEjercicio($validated, $grupoMuscularIds)
            ->load('gruposMusculares');

        if ($request->boolean('from_routine')) {
            $createdExercise = [
                'id' => (string) $ejercicio->id,
                'name' => $ejercicio->nombre,
                'group' => $ejercicio->gruposMusculares->pluck('nombre')->join(', ') ?: __('views.no_muscle_groups_short'),
                'image' => $ejercicio->imagen ? Storage::url($ejercicio->imagen) : null,
            ];

            return redirect()
                ->route('ejercicios.create', ['from_routine' => 1])
                ->with('success', __('views.exercise_created_success'))
                ->with('created_exercise_for_routine', $createdExercise);
        }
        
        return redirect()->route('ejercicios.index');
    }

    public function update(StoreEjercicioRequest $request, Ejercicio $ejercicio){
        $validated = $request->validated();
        $grupoMuscularIds = $validated['grupos_musculares'] ?? [];

        unset($validated['grupos_musculares']);

        if ($request->hasFile('imagen')){
            $validated['imagen'] = $request->file('imagen')->store('ejercicios', 'public');
        } else {
            unset($validated['imagen']);
        }

        $ejercicio->updateEjercicio($validated, $grupoMuscularIds);

        return redirect()
            ->route('ejercicios.index')
            ->with('success', __('views.exercise_updated_success'));
    }

    public function verEjercicio(int $idEjercicio){
        $ejercicio = Ejercicio::getEjercicio($idEjercicio);

        return view('ejercicios.ejercicio', compact('ejercicio'));
    }
}
