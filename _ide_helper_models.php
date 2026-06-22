<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $rutina_id
 * @property int $usuario_id
 * @property int $entrenador_id
 * @property int $activa
 * @property string $fecha_asignacion
 * @property string|null $fecha_fin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $cliente
 * @property-read \App\Models\User $entrenador
 * @property-read \App\Models\Rutina $rutina
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina activa()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina whereActiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina whereEntrenadorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina whereFechaAsignacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina whereFechaFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina whereRutinaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutina whereUsuarioId($value)
 */
	class AsignacionRutina extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $entrenador_id
 * @property int $cliente_id
 * @property string $fecha_inicio
 * @property string|null $fecha_fin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $estado
 * @property-read \App\Models\User $cliente
 * @property-read \App\Models\Entrenador $entrenador
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteEntrenador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteEntrenador newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteEntrenador query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteEntrenador whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteEntrenador whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteEntrenador whereEntrenadorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteEntrenador whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteEntrenador whereFechaFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteEntrenador whereFechaInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteEntrenador whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteEntrenador whereUpdatedAt($value)
 */
	class ClienteEntrenador extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_one_id
 * @property int $user_two_id
 * @property int|null $last_message_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $other
 * @property-read \App\Models\Message|null $lastMessage
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\User $userOne
 * @property-read \App\Models\User $userTwo
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation forUser($userId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereLastMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereUserOneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereUserTwoId($value)
 */
	class Conversation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $rutina_id
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $orden
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntreno newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntreno newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntreno query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntreno whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntreno whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntreno whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntreno whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntreno whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntreno whereRutinaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntreno whereUpdatedAt($value)
 */
	class DiaEntreno extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $dia_entreno_id
 * @property int $ejercicio_id
 * @property int $series
 * @property int $repeticiones
 * @property int|null $carga
 * @property int $orden
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntrenoEjercicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntrenoEjercicio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntrenoEjercicio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntrenoEjercicio whereCarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntrenoEjercicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntrenoEjercicio whereDiaEntrenoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntrenoEjercicio whereEjercicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntrenoEjercicio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntrenoEjercicio whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntrenoEjercicio whereRepeticiones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntrenoEjercicio whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaEntrenoEjercicio whereUpdatedAt($value)
 */
	class DiaEntrenoEjercicio extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $grupo_muscular
 * @property string|null $link_youtube
 * @property string|null $imagen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereGrupoMuscular($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereImagen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereLinkYoutube($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereUpdatedAt($value)
 */
	class Ejercicio extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property numeric|null $precio_mensual
 * @property int|null $calificacion_media
 * @property int|null $numero_clientes
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $clientes
 * @property-read int|null $clientes_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereCalificacionMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereNumeroClientes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador wherePrecioMensual($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereUserId($value)
 */
	class Entrenador extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $conversation_id
 * @property int $sender_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Conversation $conversation
 * @property-read \App\Models\User $sender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereConversationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereUpdatedAt($value)
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $usuario_id
 * @property string $fecha_registro
 * @property numeric $peso
 * @property numeric $altura
 * @property numeric|null $porcentaje_grasa
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroCorporal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroCorporal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroCorporal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroCorporal whereAltura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroCorporal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroCorporal whereFechaRegistro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroCorporal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroCorporal wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroCorporal wherePorcentajeGrasa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroCorporal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroCorporal whereUsuarioId($value)
 */
	class RegistroCorporal extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $registro_entrenamiento_id
 * @property int $dia_entreno_ejercicio_id
 * @property int|null $series_realizadas
 * @property int|null $repeticiones_realizadas
 * @property numeric|null $peso_utilizado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEjercicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEjercicio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEjercicio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEjercicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEjercicio whereDiaEntrenoEjercicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEjercicio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEjercicio wherePesoUtilizado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEjercicio whereRegistroEntrenamientoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEjercicio whereRepeticionesRealizadas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEjercicio whereSeriesRealizadas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEjercicio whereUpdatedAt($value)
 */
	class RegistroEjercicio extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $usuario_id
 * @property int $asignacion_rutina_id
 * @property int $dia_entreno_id
 * @property string $fecha_entrenamiento
 * @property int $pasos_realizados
 * @property string|null $notas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEntrenamiento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEntrenamiento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEntrenamiento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEntrenamiento whereAsignacionRutinaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEntrenamiento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEntrenamiento whereDiaEntrenoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEntrenamiento whereFechaEntrenamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEntrenamiento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEntrenamiento whereNotas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEntrenamiento wherePasosRealizados($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEntrenamiento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistroEntrenamiento whereUsuarioId($value)
 */
	class RegistroEntrenamiento extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $autor_id
 * @property string|null $nombre
 * @property string|null $descripcion
 * @property int|null $kcal_objetivo
 * @property int|null $pasos_objetivo
 * @property int|null $duracion_aproximada_min
 * @property int $dias_entreno
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AsignacionRutina> $asignaciones
 * @property-read int|null $asignaciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AsignacionRutina> $asignacionesActivas
 * @property-read int|null $asignaciones_activas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $clientesAsignados
 * @property-read int|null $clientes_asignados_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereAutorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereDiasEntreno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereDuracionAproximadaMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereKcalObjetivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina wherePasosObjetivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereUpdatedAt($value)
 */
	class Rutina extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $rol
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Entrenador|null $entrenador
 * @property-read \App\Models\Entrenador|null $entrenadorAsignado
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Conversation> $receivedConversations
 * @property-read int|null $received_conversations_count
 * @property-read \App\Models\ClienteEntrenador|null $relacionEntrenador
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $sentMessages
 * @property-read int|null $sent_messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Conversation> $startedConversations
 * @property-read int|null $started_conversations_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRol($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

