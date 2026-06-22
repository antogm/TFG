<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class AsignacionRutina extends Model
{
    protected $table = 'asignacion_rutinas';

    protected $fillable = [
        'rutina_id',
        'usuario_id',
        'entrenador_id',
        'activa',
        'fecha_asignacion',
        'fecha_fin',
    ];

    protected $casts = [
        'activa' => 'boolean',
        'fecha_asignacion' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    /////////// RELACIONES

    public function rutina(): BelongsTo
    {
        return $this->belongsTo(Rutina::class, 'rutina_id');
    }

    public function rutinaConDetalle(): BelongsTo
    {
        return $this->belongsTo(Rutina::class, 'rutina_id')->conDetalle();
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function entrenador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'entrenador_id');
    }

    public function registrosEntrenamientos(): HasMany
    {
        return $this->hasMany(RegistroEntrenamiento::class, 'asignacion_rutina_id');
    }

    ////////////////////////////

    public function scopeActiva(Builder $query)
    {
        return $query->where('activa', 1);
    }

    public function scopeDeCliente(Builder $query, int $clienteId)
    {
        return $query->where('usuario_id', $clienteId);
    }

    public static function asignarRutina(int $rutinaId, int $clienteId, int $entrenadorId): bool
    {
        return DB::transaction(function () use ($rutinaId, $clienteId, $entrenadorId) {
            self::desasignarRutina($clienteId);

            $asignacion = self::firstOrNew([
                'rutina_id' => $rutinaId,
                'usuario_id' => $clienteId,
            ]);

            $asignacion->fill([
                'entrenador_id' => $entrenadorId,
                'activa' => true,
                'fecha_asignacion' => now(),
                'fecha_fin' => null,
            ]);

            return $asignacion->save();
        });
    }

    public static function desasignarRutina(int $clienteId): int
    {
        return self::query()
            ->where('usuario_id', $clienteId)
            ->where('activa', 1)
            ->update([
                'activa' => 0,
                'fecha_fin' => now(),
            ]);
    }

    public static function desasignarRutinaDeEntrenador(int $clienteId, int $autorId): bool
    {
        $cliente = User::query()
            ->with('asignacionRutinaActiva.rutina:id,autor_id')
            ->find($clienteId);

        $asignacionActiva = $cliente?->asignacionRutinaActiva;

        if (! $asignacionActiva || (int) $asignacionActiva->rutina?->autor_id !== $autorId) {
            return false;
        }

        return $asignacionActiva->update([
            'activa' => 0,
            'fecha_fin' => now(),
        ]);
    }
}
