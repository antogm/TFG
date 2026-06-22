<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClienteEntrenador extends Model
{
    protected $table = 'cliente_entrenadors';

    protected $fillable = [
        'entrenador_id',
        'cliente_id',
        'fecha_solicitud',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'valoracion',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'valoracion' => 'decimal:1',
    ];

    public static function clientePuedeSolicitar(int $clienteId): bool{
        return !self::query()->where('cliente_id', $clienteId)
            ->whereNotIn('estado', ['cancelada', 'rechazada'])
            ->exists();
    }

    public static function crearSolicitudPendiente(int $clienteId, int $entrenadorId): self{
        $solicitud = self::firstOrNew([
            'entrenador_id' => $entrenadorId,
            'cliente_id' => $clienteId,
        ]);

        $solicitud->fecha_inicio = null;
        $solicitud->fecha_fin = null;
        $solicitud->fecha_solicitud = now();
        $solicitud->estado = 'pendiente';
        $solicitud->save();

        return $solicitud;
    }

    public static function existeRelacionActiva(int $entrenadorId, int $clienteId): bool{
        return self::query()
            ->where('entrenador_id', $entrenadorId)
            ->where('cliente_id', $clienteId)
            ->where('estado', 'activa')
            ->exists();
    }

    public static function addValoracion(int $entrenadorId, int $clienteId, float $valoracion): bool{
        return DB::transaction(function () use ($entrenadorId, $clienteId, $valoracion) {
            $colaboracion = self::query()
                ->where('entrenador_id', $entrenadorId)
                ->where('cliente_id', $clienteId)
                ->where('estado', 'activa')
                ->first();

            if (! $colaboracion || $colaboracion->valoracion !== null) {
                return false;
            }

            $colaboracion->valoracion = $valoracion;
            $colaboracion->save();

            $entrenador = Entrenador::query()->find($entrenadorId);

            if (! $entrenador) {
                return false;
            }

            $entrenador->numero_valoraciones = (int) $entrenador->numero_valoraciones + 1;
            self::recalcularValoracionesEntrenador($entrenador);

            return true;
        });
    }

    public static function eliminarValoracion(int $entrenadorId, int $clienteId): bool{
        return DB::transaction(function () use ($entrenadorId, $clienteId) {
            $colaboracion = self::query()
                ->where('entrenador_id', $entrenadorId)
                ->where('cliente_id', $clienteId)
                ->whereNotNull('valoracion')
                ->first();

            if (! $colaboracion) {
                return false;
            }

            $colaboracion->valoracion = null;
            $colaboracion->save();

            $entrenador = Entrenador::query()->find($entrenadorId);

            if (! $entrenador) {
                return false;
            }

            $entrenador->numero_valoraciones = max(0, (int) $entrenador->numero_valoraciones - 1);
            self::recalcularValoracionesEntrenador($entrenador);

            return true;
        });
    }

    private static function recalcularValoracionesEntrenador(Entrenador $entrenador): void{
        if ((int) $entrenador->numero_valoraciones === 0) {
            $entrenador->rating = null;
            $entrenador->save();
            return;
        }

        $sumaValoraciones = (float) self::query()
            ->where('entrenador_id', $entrenador->id)
            ->whereNotNull('valoracion')
            ->sum('valoracion');

        $entrenador->rating = round($sumaValoraciones / (int) $entrenador->numero_valoraciones, 1);
        $entrenador->save();
    }

    public static function cancelarColaboracion(int $entrenadorId, int $clienteId): bool{
        return DB::transaction(function () use ($entrenadorId, $clienteId) {
            $colaboracion = self::query()->where('cliente_id', $clienteId)
                ->where('entrenador_id', $entrenadorId)
                ->whereIn('estado', ['pendiente', 'activa'])
                ->first();

            if (! $colaboracion) {
                return false;
            }

            if ($colaboracion->estado === 'activa') {
                AsignacionRutina::desasignarRutinaDeEntrenador($clienteId, $entrenadorId);

                $colaboracion->fecha_fin = now();
                $colaboracion->estado = 'cancelada';
            } elseif ($colaboracion->estado === 'pendiente') {
                $colaboracion->fecha_solicitud = null;
                $colaboracion->estado = 'rechazada';
            }

            return $colaboracion->save();
        });
    }

    public static function aceptarSolicitudPendiente(int $entrenadorId, int $clienteId): bool{
        return self::query()->where('cliente_id', $clienteId)
            ->where('entrenador_id', $entrenadorId)
            ->where('estado', 'pendiente')
            ->update([
                'estado' => 'activa',
                'fecha_inicio' => now(),
                'fecha_fin' => null,
            ]) > 0;
    }

    public static function rechazarSolicitudPendiente(int $entrenadorId, int $clienteId): bool{
        return self::cancelarColaboracion($entrenadorId, $clienteId);
    }

    public static function getNumeroClientesAsignados(int $entrenadorId): int{
        return (int) self::query()->where('entrenador_id', $entrenadorId)
            ->where('estado', 'activa')
            ->count();
    }

    public static function getSolicitudesPendientes(int $entrenadorId)
    {
        return self::with('cliente')
            ->where('entrenador_id', $entrenadorId)
            ->where('estado', 'pendiente')
            ->orderByDesc('fecha_solicitud')
            ->simplePaginate(15);
    }

    public static function getNumeroSolicitudesPendientes(int $entrenadorId): int{
        return (int) self::query()
            ->where('entrenador_id', $entrenadorId)
            ->where('estado', 'pendiente')
            ->count();
    }

    /////////// RELACIONES

    public function entrenador(){
        return $this->belongsTo(Entrenador::class, 'entrenador_id');
    }

    public function cliente(){
        return $this->belongsTo(User::class, 'cliente_id');
    }

    ////////////////////////////
}
