<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Ejercicio extends Model
{
    protected $table = 'ejercicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'grupo_muscular',
        'link_youtube',
        'imagen',
    ];

    /////////// RELACIONES

    public function grupoMuscularPrincipal(): BelongsTo
    {
        return $this->belongsTo(GrupoMuscular::class, 'grupo_muscular');
    }

    public function gruposMusculares(): BelongsToMany
    {
        return $this->belongsToMany(GrupoMuscular::class);
    }

    ////////////////////////////

    public static function getEjercicios()
    {
        return self::with('gruposMusculares')->get();
    }

    public static function getEjerciciosPaginados(string $search = '')
    {
        $ejercicios = self::with('gruposMusculares');

        if ($search !== '') {
            $ejercicios->where('nombre', 'like', "%{$search}%");
        }

        return $ejercicios
            ->orderBy('nombre')
            ->simplePaginate(15)
            ->withQueryString();
    }

    public function cargarGruposMusculares(): self
    {
        return $this->load('gruposMusculares');
    }

    public function getYoutubeEmbedUrl(): ?string
    {
        if (!$this->link_youtube) {
            return null;
        }

        $host = parse_url($this->link_youtube, PHP_URL_HOST) ?? '';
        $path = parse_url($this->link_youtube, PHP_URL_PATH) ?? '';
        $videoId = null;

        if (str_contains($host, 'youtu.be')) {
            $videoId = trim($path, '/');
        } elseif (str_contains($host, 'youtube.com')) {
            if ($path === '/watch') {
                parse_str(parse_url($this->link_youtube, PHP_URL_QUERY) ?? '', $query);
                $videoId = $query['v'] ?? null;
            } elseif (str_starts_with($path, '/embed/')) {
                return $this->link_youtube;
            } elseif (str_starts_with($path, '/shorts/')) {
                $videoId = str_replace('/shorts/', '', $path);
            }
        }

        if (!$videoId) {
            return null;
        }

        return 'https://www.youtube.com/embed/' . strtok($videoId, '/');
    }

    public static function createEjercicio(array $data, array $grupoMuscularIds)
    {
        return DB::transaction(function () use ($data, $grupoMuscularIds) {
            $data['grupo_muscular'] = $grupoMuscularIds[0] ?? null;
            $ejercicio = self::create($data);
            $ejercicio->gruposMusculares()->sync($grupoMuscularIds);

            return $ejercicio;
        });
    }

    public function updateEjercicio(array $data, array $grupoMuscularIds): self
    {
        return DB::transaction(function () use ($data, $grupoMuscularIds) {
            $data['grupo_muscular'] = $grupoMuscularIds[0] ?? null;
            $this->update($data);
            $this->gruposMusculares()->sync($grupoMuscularIds);

            return $this;
        });
    }

    
}
