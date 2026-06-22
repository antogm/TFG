<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class RegistroCorporal extends Model
{
    protected $table = 'registro_corporals';

    protected $fillable = [
        'usuario_id',
        'fecha_registro',
        'fecha_edicion',
        'peso',
        'masa_muscular',
        'porcentaje_grasa',
    ];

    protected $casts = [
        'fecha_registro' => 'date',
        'fecha_edicion' => 'datetime',
        'peso' => 'decimal:2',
        'masa_muscular' => 'decimal:2',
        'porcentaje_grasa' => 'decimal:2',
    ];

    /////////// RELACIONES

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(RegistroCorporalImage::class, 'registro_corporal_id');
    }

    ////////////////////////////

    public static function crearRegistroCorporal(User $usuario, array $data): ?self
    {
        $registroCorporal = new self();
        $registroCorporal->peso = $data['peso'];
        $registroCorporal->masa_muscular = $data['masa_muscular'] ?? null;
        $registroCorporal->porcentaje_grasa = $data['porcentaje_grasa'] ?? null;
        $registroCorporal->fecha_registro = $data['fecha'];

        $guardado = $usuario->registrosCorporales()->save($registroCorporal);

        if (! $guardado) {
            return null;
        }

        return $registroCorporal;
    }

    public function guardarImagenes(array $imagenes): void
    {
        $directorio = 'registro-corporal/' . $this->usuario_id;
        $fechaRegistro = $this->fecha_registro ? $this->asDateTime($this->fecha_registro)->format('Y-m-d') : now()->format('Y-m-d');
        $siguienteIndice = $this->imagenes()->count() + 1;

        foreach ($imagenes as $imagen) {
            if (! $imagen instanceof UploadedFile) {
                continue;
            }

            $extension = $imagen->extension() ?: 'jpg';
            $nombreArchivo = sprintf(
                'registro-%d-%s-foto-%d-%s.%s',
                $this->id,
                $fechaRegistro,
                $siguienteIndice,
                Str::lower(Str::random(8)),
                $extension
            );

            $path = $imagen->storeAs($directorio, $nombreArchivo, 'local');

            if (! $path) {
                continue;
            }

            $this->imagenes()->create([
                'path' => $path,
            ]);

            $siguienteIndice++;
        }
    }

    public function esPropietario(int $usuarioId): bool
    {
        return (int) $this->usuario_id === $usuarioId;
    }

    public function puedeVer(User $usuario): bool
    {
        if ($this->esPropietario((int) $usuario->id)) {
            return true;
        }

        if ($usuario->rol !== 'entrenador') {
            return false;
        }

        return ClienteEntrenador::existeRelacionActiva((int) $usuario->id, (int) $this->usuario_id);
    }

    public function actualizarConDatos(array $data): void
    {
        $this->peso = $data['peso'];
        $this->masa_muscular = $data['masa_muscular'] ?? null;
        $this->porcentaje_grasa = $data['porcentaje_grasa'] ?? null;
        $this->fecha_registro = $data['fecha'];
        $this->fecha_edicion = now();
        $this->save();
    }

	// Si se elimina un registro corporal, elimina automáticamente sus imágenes
    protected static function booted(): void
    {
        static::deleting(function (self $registroCorporal): void {
            foreach ($registroCorporal->imagenes()->get() as $imagen) {
                $imagen->delete();
            }
        });
    }
}
