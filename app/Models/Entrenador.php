<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Entrenador extends Model
{
    protected $table = 'entrenadores';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'precio_mensual',
        'calificacion_media',
        'rating',
        'numero_valoraciones',
        'numero_clientes',
        'descripcion',
        'ocultar_lista_publica',
        'bloquear_solicitudes_entrantes',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'numero_valoraciones' => 'integer',
        'ocultar_lista_publica' => 'boolean',
        'bloquear_solicitudes_entrantes' => 'boolean',
    ];

    /////////// RELACIONES

    public function user(){
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function colaboraciones(){
        return $this->hasMany(ClienteEntrenador::class, 'entrenador_id', 'id');
    }

    public function solicitudesPendientes(){
        return $this->colaboraciones()->where('estado', 'pendiente');
    }

    public function clientes(){
        return $this->belongsToMany(
            User::class,
            'cliente_entrenadors',
            'entrenador_id',
            'cliente_id',
            'id',
            'id'
        )->wherePivot('estado', 'activa');
    }

    public function rutinas(){
        return $this->hasMany(Rutina::class, 'autor_id', 'id')
            ->withCount(['clientesAsignados as numero_clientes_asignados'])
            ->orderBy('nombre');
    }

    ////////////////////////////

    public function clientesConResumen(): Collection
    {
        return $this->clientes()
            ->with([
                'asignacionRutinaActiva',
                'ultimoRegistroCorporal',
                'ultimoRegistroEntrenamiento',
            ])
            ->orderBy('name')
            ->get();
    }

    public function clientesSinRutina(): Collection
    {
        return $this->clientes()
            ->whereDoesntHave('asignacionRutinaActiva')
            ->orderBy('name')
            ->get();
    }

    public function getClientes(string $search = '')
    {
        $clientes = $this->clientes()->with([
            'ultimoRegistroCorporal',
            'ultimoRegistroEntrenamiento',
        ]);

        if ($search !== '') {
            $clientes->where(function ($query) use ($search) {
                $query->where('users.name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%");
            });
        }

        return $clientes
            ->orderBy('users.name')
            ->simplePaginate(15)
            ->withQueryString();
    }

    public static function getEntrenadoresVisibles()
    {
        return self::visibles()
            ->with('user')
            ->simplePaginate(15);
    }

    public function numeroClientesAnteriores(): int
    {
        return (int) $this->colaboraciones()
            ->where('estado', 'cancelada')
            ->distinct('cliente_id')
            ->count('cliente_id');
    }

    public function cargarUsuario(): self
    {
        return $this->loadMissing('user');
    }

    public function numeroClientesActuales(): int
    {
        return $this->clientes()->count();
    }

    public function numeroRutinasCreadas(): int
    {
        return $this->rutinas()->count();
    }

    public function datosDashboard(): array
    {
        $clientes = $this->clientesConResumen();
        $umbralInactividad = now()->subDays(7);
        $clientesSinRutina = $clientes
            ->filter(fn (User $cliente) => ! $cliente->asignacionRutinaActiva)
            ->values();

        $clientesInactivos = $clientes
            ->map(function (User $cliente) {
                return [
                    'cliente' => $cliente,
                    'ultimaActividad' => $cliente->ultimaActividadRegistrada(),
                ];
            })
            ->filter(function (array $item) use ($umbralInactividad) {
                return ! $item['ultimaActividad'] || $item['ultimaActividad']->lt($umbralInactividad);
            })
            ->values();

        return [
            'numClientes' => $clientes->count(),
            'numSolicitudesPendientes' => $this->solicitudesPendientes()->count(),
            'numMensajesSinLeer' => $this->user?->numeroMensajesSinLeer() ?? 0,
            'clientesSinRutina' => $clientesSinRutina,
            'clientesInactivos' => $clientesInactivos,
            'ultimosEntrenosClientes' => $this->ultimosEntrenosClientes(),
        ];
    }

    public function scopeVisibles(Builder $query){
        return $query->where('ocultar_lista_publica', false);
    }

    public function cancelarColaboraciones(): int
    {
        $colaboraciones = $this->colaboraciones()
            ->whereIn('estado', ['pendiente', 'activa'])
            ->get();

        $canceladas = 0;

        foreach ($colaboraciones as $colaboracion) {
            if ($colaboracion->estado === 'activa') {
                AsignacionRutina::desasignarRutinaDeEntrenador($colaboracion->cliente_id, $this->id);

                $colaboracion->fecha_fin = now();
                $colaboracion->estado = 'cancelada';
            } elseif ($colaboracion->estado === 'pendiente') {
                $colaboracion->fecha_solicitud = null;
                $colaboracion->estado = 'rechazada';
            }

            if ($colaboracion->save()) {
                $canceladas++;
            }
        }

        return $canceladas;
    }

    private function ultimosEntrenosClientes(): Collection
    {
        $registros = RegistroEntrenamiento::query()
            ->with('usuario:id,name')
            ->whereRelation('usuario.relacionEntrenador', 'entrenador_id', $this->id)
            ->orderBy('fecha_entrenamiento', 'desc')
            ->limit(5)
            ->get();

        $ultimosEntrenos = collect();

        foreach ($registros as $registroEntrenamiento) {
            $ultimosEntrenos->push([
                'cliente' => $registroEntrenamiento->usuario?->name ?? '-',
                'entreno' => $registroEntrenamiento->nombre,
                'fecha' => $registroEntrenamiento->fecha_entrenamiento?->format('d/m/Y') ?? '-',
            ]);
        }

        return $ultimosEntrenos;
    }
}
