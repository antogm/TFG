<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Rutina extends Model
{
    protected $table = 'rutinas';

    protected $fillable = [
        'autor_id',
        'nombre',
        'descripcion',
        'kcal_objetivo',
        'pasos_objetivo',
        'duracion_aproximada_min',
        'dias_entreno',
    ];

    /////////// RELACIONES

    public function autor(){
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function asignaciones(){
        return $this->hasMany(AsignacionRutina::class, 'rutina_id');
    }

    public function asignacionesActivas(){
        return $this->hasMany(AsignacionRutina::class, 'rutina_id')->where('activa', 1);
    }

    public function clientesAsignados(){
        return $this->belongsToMany(User::class, 'asignacion_rutinas', 'rutina_id', 'usuario_id')
            ->wherePivot('activa', 1);
    }

    public function diasEntreno(): HasMany
    {
        return $this->hasMany(DiaEntreno::class, 'rutina_id');
    }

    ////////////////////////////

    public function usuarioTieneAsignacion(User $usuario): bool
    {
        $usuario->loadMissing('asignacionRutinaActiva');

        return (int) $usuario->asignacionRutinaActiva?->rutina_id === (int) $this->id;
    }

    public function scopeDeAutor(Builder $query, int $autorId): Builder
    {
        return $query->where('autor_id', $autorId);
    }

    public function scopeConNumeroClientesAsignados(Builder $query): Builder
    {
        return $query->withCount(['clientesAsignados as numero_clientes_asignados']);
    }

    public function scopeClientesAsignados(Builder $query): Builder
    {
        return $query->with(['clientesAsignados' => fn ($subquery) => $subquery
            ->orderBy('users.name')]);
    }

    public function scopeConDetalle(Builder $query): Builder
    {
        return $query->with([
            'autor',
            'diasEntreno.ejerciciosProgramados.ejercicio.gruposMusculares',
        ]);
    }

    public function scopeAccesiblePara(Builder $query, User $usuario): Builder
    {
        if ($usuario->rol === 'entrenador') {
            return $query->deAutor($usuario->id);
        }

        return $query->whereHas('asignacionesActivas', function (Builder $subquery) use ($usuario) {
            $subquery->where('usuario_id', $usuario->id);
        });
    }

    public static function getRutinas(int $entrenadorId, string $search = '')
    {
        $rutinas = self::query()
            ->deAutor($entrenadorId)
            ->conNumeroClientesAsignados()
            ->clientesAsignados();

        if ($search !== '') {
            $rutinas->where('nombre', 'like', "%{$search}%");
        }

        return $rutinas
            ->orderBy('nombre')
            ->simplePaginate(15)
            ->withQueryString();
    }

    public function cargarRutina(): self
    {
        return $this->load([
            'autor',
            'diasEntreno.ejerciciosProgramados.ejercicio.gruposMusculares',
        ]);
    }

    public static function getRutina(int $rutinaId, User $usuario): self
    {
        return self::query()
            ->conDetalle()
            ->accesiblePara($usuario)
            ->findOrFail($rutinaId);
    }

    public static function asignarCliente(int $rutinaId, int $clienteId, int $entrenadorId): bool
    {
        return DB::transaction(function () use ($rutinaId, $clienteId, $entrenadorId) {
            $rutina = self::query()
                ->deAutor($entrenadorId)
                ->findOrFail($rutinaId);

            return AsignacionRutina::asignarRutina($rutina->id, $clienteId, $entrenadorId);
        });
    }

    public static function desasignarCliente(int $clienteId): bool
    {
        return AsignacionRutina::desasignarRutina($clienteId) > 0;
    }

    public static function sincronizarClientesAsignados(int $rutinaId, int $entrenadorId, array $clienteIds): self
    {
        $rutina = self::getRutinaPorAutor($rutinaId, $entrenadorId);
        $entrenador = Entrenador::query()->findOrFail($entrenadorId);
        $clientesSeleccionados = self::normalizarIdsClientes($clienteIds);
        $clientesPermitidos = self::getIdsClientesPermitidos($rutina, $entrenador);
        $clientesActuales = self::getIdsClientesActuales($rutina);

        self::validarClientesSeleccionados($clientesSeleccionados, $clientesPermitidos);

		// Si el cliente estaba en la lista de clientes y no en la nueva, le desasigna la rutina
        foreach ($clientesActuales as $clienteId) {
            if (! in_array($clienteId, $clientesSeleccionados, true)) {
                self::desasignarCliente($clienteId);
            }
        }

		// Si el cliente no estaba en la lista de clientes y sí en la nueva, le asigna la rutina
        foreach ($clientesSeleccionados as $clienteId) {
            if (! in_array($clienteId, $clientesActuales, true)) {
                self::asignarCliente($rutina->id, $clienteId, $entrenadorId);
            }
        }

        return $rutina;
    }

    private static function normalizarIdsClientes(array $clienteIds): array
    {
        return collect($clienteIds)
            ->map(fn ($clienteId) => (int) $clienteId)
            ->unique()
            ->values()
            ->all();
    }

    private static function getIdsClientesPermitidos(self $rutina, Entrenador $entrenador): array
    {
        $clientesSinRutina = $entrenador->clientesSinRutina()->pluck('id');
        $clientesActuales = $rutina->clientesAsignados->pluck('id');

        return $clientesSinRutina
            ->merge($clientesActuales)
            ->map(fn ($clienteId) => (int) $clienteId)
            ->unique()
            ->values()
            ->all();
    }

    private static function getIdsClientesActuales(self $rutina): array
    {
        return $rutina->clientesAsignados
            ->pluck('id')
            ->map(fn ($clienteId) => (int) $clienteId)
            ->all();
    }

    private static function validarClientesSeleccionados(array $clientesSeleccionados, array $clientesPermitidos): void
    {
        foreach ($clientesSeleccionados as $clienteId) {
            if (! in_array($clienteId, $clientesPermitidos, true)) {
                abort(403);
            }
        }
    }
    public function getDayPlansFormulario(): array
    {
        $dayPlans = [];

        for ($i = 0; $i < $this->dias_entreno; $i++) {
            $dayPlans[$i] = [
                'name' => '',
                'selectedExerciseId' => '',
                'exercises' => [],
            ];
        }

        foreach ($this->diasEntreno->sortBy('orden') as $dia) {
            $dayIndex = $dia->orden - 1;

            if (!isset($dayPlans[$dayIndex])) {
                continue;
            }

            $dayPlans[$dayIndex]['name'] = $dia->nombre;

            foreach ($dia->ejerciciosProgramados->sortBy('orden') as $ejercicioProgramado) {
                $ejercicio = $ejercicioProgramado->ejercicio;

                $dayPlans[$dayIndex]['exercises'][] = [
                    'exerciseId' => (string) $ejercicioProgramado->ejercicio_id,
                    'name' => $ejercicio->nombre,
                    'group' => $ejercicio->gruposMusculares->pluck('nombre')->join(', ') ?: __('views.no_muscle_groups_short'),
                    'image' => $ejercicio->imagen ? \Illuminate\Support\Facades\Storage::url($ejercicio->imagen) : null,
                    'duracion_segundos' => $ejercicioProgramado->duracion_segundos,
                    'series' => $ejercicioProgramado->series,
                    'repeticiones' => $ejercicioProgramado->repeticiones,
                    'carga' => $ejercicioProgramado->carga,
                ];
            }
        }

        return $dayPlans;
    }

    public static function createRutina(array $data): self
    {
        return DB::transaction(function () use ($data) {
            $dias = $data['dias'] ?? [];

            $rutina = self::create([
                'autor_id' => Auth::id(),
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'] ?? null,
                'kcal_objetivo' => $data['kcal_objetivo'] ?? null,
                'pasos_objetivo' => $data['pasos_objetivo'] ?? null,
                'duracion_aproximada_min' => $data['duracion_aproximada_min'] ?? null,
                'dias_entreno' => $data['dias_entreno'],
            ]);

            $rutina->guardarDiasEntreno($dias);

            return $rutina;
        });
    }

    public function guardarDiasEntreno(array $dias): void
    {
        for ($dayNumber = 1; $dayNumber <= $this->dias_entreno; $dayNumber++) {
            $dayIndex = $dayNumber - 1;
            $dia = $dias[$dayIndex] ?? [];
            $nombreDia = trim($dia['nombre'] ?? '');

            $diaEntreno = $this->diasEntreno()->create([
                'nombre' => $nombreDia !== '' ? $nombreDia : __("views.day_label", ["number" => $dayNumber]),
                'descripcion' => null,
                'orden' => $dayNumber,
            ]);

            $ejercicios = $dias[$dayIndex]['ejercicios'] ?? [];

            if ($ejercicios !== []) {
                $diaEntreno->guardarEjerciciosProgramados($ejercicios);
            }
        }
    }

    public function updateRutina(array $data): self
    {
        return DB::transaction(function () use ($data) {
            $this->load('diasEntreno.ejerciciosProgramados');

            $this->update([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'] ?? null,
                'kcal_objetivo' => $data['kcal_objetivo'] ?? null,
                'pasos_objetivo' => $data['pasos_objetivo'] ?? null,
                'duracion_aproximada_min' => $data['duracion_aproximada_min'] ?? null,
                'dias_entreno' => $data['dias_entreno'],
            ]);

            foreach ($this->diasEntreno as $dia) {
                $dia->ejerciciosProgramados()->delete();
                $dia->delete();
            }

            $this->guardarDiasEntreno($data['dias'] ?? []);

            return $this;
        });
    }

    public function deleteRutina(): void
    {
        DB::transaction(function () {
            $this->load([
                'diasEntreno.ejerciciosProgramados',
                'asignaciones',
            ]);

            foreach ($this->diasEntreno as $dia) {
                $dia->ejerciciosProgramados()->delete();
                $dia->delete();
            }

            $this->asignaciones()->delete();
            $this->delete();
        });
    }
}
