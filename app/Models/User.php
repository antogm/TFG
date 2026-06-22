<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'genero',
        'altura',
        'objetivo',
        'imagen',
        'bloquear_mensajes_desconocidos',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'altura' => 'integer',
            'bloquear_mensajes_desconocidos' => 'boolean',
        ];
    }

    /////////// RELACIONES

    public function startedConversations(){
        return $this->hasMany(Conversation::class, 'user_one_id');
    }

    public function receivedConversations(){
        return $this->hasMany(Conversation::class, 'user_two_id');
    }

    public function chatConversations(): Builder{
        return Conversation::query()
            ->whereParticipant($this->id)
            ->withChatSummary();
    }

    public function sentMessages(){
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function entrenador(){
        return $this->hasOne(Entrenador::class, 'id', 'id');
    }

    public function relacionEntrenador(){
        return $this
            ->hasOne(ClienteEntrenador::class, 'cliente_id')
            ->where('estado', 'activa');
    }

    public function solicitudPendiente(){
        return $this
            ->hasOne(ClienteEntrenador::class, 'cliente_id')
            ->where('estado', 'pendiente');
    }

    public function entrenadorAsignado(){
        return $this
            ->hasOneThrough(Entrenador::class, ClienteEntrenador::class, 'cliente_id', 'id', 'id', 'entrenador_id')
            ->where('estado', 'activa');
    }

    public function registrosCorporales(){
        return $this->hasMany(RegistroCorporal::class, 'usuario_id');
    }

    public function ultimoRegistroCorporal(){
        return $this->hasOne(RegistroCorporal::class, 'usuario_id')->latestOfMany('fecha_registro');
    }

    public function ultimoRegistroMasaMuscular(){
        return $this->hasOne(RegistroCorporal::class, 'usuario_id')
            ->whereNotNull('masa_muscular')
            ->latestOfMany('fecha_registro');
    }

    public function ultimoRegistroGrasaCorporal(){
        return $this->hasOne(RegistroCorporal::class, 'usuario_id')
            ->whereNotNull('porcentaje_grasa')
            ->latestOfMany('fecha_registro');
    }

    public function registrosEntrenamientos(){
        return $this->hasMany(RegistroEntrenamiento::class, 'usuario_id');
    }

    public function ultimoRegistroEntrenamiento(){
        return $this->hasOne(RegistroEntrenamiento::class, 'usuario_id')->latestOfMany('fecha_entrenamiento');
    }

    public function rutinas(){
        return $this->hasMany(Rutina::class, 'autor_id');
    }

    public function asignacionRutinaActiva(){
        return $this->hasOne(AsignacionRutina::class, 'usuario_id')
            ->where('activa', 1);
    }

    ////////////////////////////

    public function altaEntrenador(): void
    {
        DB::transaction(function () {
            $this->entrenador()->updateOrCreate([], [
                'ocultar_lista_publica' => false,
                'bloquear_solicitudes_entrantes' => false,
            ]);

            $this->forceFill(['rol' => 'entrenador'])->save();
            $this->load('entrenador');
        });
    }

    public function bajaEntrenador(): void
    {
        DB::transaction(function () {
            $entrenador = $this->entrenador;

            if ($entrenador) {
                $entrenador->cancelarColaboraciones();

                $entrenador->update([
                    'ocultar_lista_publica' => true,
                    'bloquear_solicitudes_entrantes' => true,
                    'numero_clientes' => 0,
                ]);
            }

            $this->forceFill(['rol' => 'usuario'])->save();
        });
    }

    public function numeroMensajesSinLeer(): int
    {
        $conversacionesIds = $this->chatConversations()->pluck('id');

        return Message::whereIn('conversation_id', $conversacionesIds)
            ->where('sender_id', '!=', $this->id)
            ->where('leido', false)
            ->count();
    }

    public function ultimaActividadRegistrada()
    {
        $ultimaMedicion = $this->ultimoRegistroCorporal?->fecha_registro;
        $ultimoEntreno = $this->ultimoRegistroEntrenamiento?->fecha_entrenamiento;

        if (! $ultimaMedicion) {
            return $ultimoEntreno;
        }

        if (! $ultimoEntreno) {
            return $ultimaMedicion;
        }

        return strtotime((string) $ultimaMedicion) > strtotime((string) $ultimoEntreno)
            ? $ultimaMedicion
            : $ultimoEntreno;
    }

    public function cargarDatosProgreso(): self
    {
        $this->loadMissing([
            'asignacionRutinaActiva.rutina.autor',
            'entrenadorAsignado.user',
            'ultimoRegistroCorporal',
            'ultimoRegistroMasaMuscular',
            'ultimoRegistroGrasaCorporal',
            'registrosCorporales' => fn ($query) => $query->orderBy('fecha_registro'),
            'registrosEntrenamientos' => fn ($query) => $query->orderBy('fecha_entrenamiento'),
        ]);

        return $this;
    }

    public function getRegistrosCorporalesGrafica(): Collection
    {
        if (! $this->relationLoaded('registrosCorporales')) {
            $this->load([
                'registrosCorporales' => fn ($query) => $query->orderBy('fecha_registro'),
            ]);
        }

        return $this->registrosCorporales;
    }

    public function getRegistrosEntrenamientosGrafica(): Collection
    {
        if (! $this->relationLoaded('registrosEntrenamientos')) {
            $this->load([
                'registrosEntrenamientos' => fn ($query) => $query->orderBy('fecha_entrenamiento'),
            ]);
        }

        return $this->registrosEntrenamientos;
    }

    public function getRutinas(): Collection
    {
        return $this->rutinas()->orderBy('nombre')->get();
    }

    public function getRelacionActivaConEntrenador(int $entrenadorId): ?ClienteEntrenador
    {
        return $this->relacionEntrenador()
            ->where('entrenador_id', $entrenadorId)
            ->first();
    }

    public function getRegistrosCorporales()
    {
        return $this->registrosCorporales()
            ->orderBy('fecha_registro', 'desc')
            ->simplePaginate(15, ['*'], 'corporal_page')
            ->withQueryString();
    }

    public function getRegistrosEntrenamientos()
    {
        return $this->registrosEntrenamientos()
            ->with('asignacionRutina.rutina:id,nombre')
            ->orderBy('fecha_entrenamiento', 'desc')
            ->simplePaginate(15, ['*'], 'entrenos_page')
            ->withQueryString()
            ->through(function ($registroEntreno) {
                return [
                    'id' => $registroEntreno->id,
                    'fecha' => $registroEntreno->fecha_entrenamiento?->format('d/m/Y') ?? '-',
                    'fecha_orden' => $registroEntreno->fecha_entrenamiento?->format('Y-m-d') ?? '',
                    'nombre' => $registroEntreno->nombre,
                    'rutina' => $registroEntreno->asignacionRutina?->rutina?->nombre ?? '-',
                ];
            });
    }
}
