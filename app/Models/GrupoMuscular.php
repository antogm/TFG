<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GrupoMuscular extends Model
{
    protected $table = 'grupos_musculares';

    protected $fillable = [
        'nombre',
        'parent_id',
    ];

    /////////// RELACIONES

    public function ejercicios(): BelongsToMany{
        return $this->belongsToMany(Ejercicio::class);
    }

    public function parent(): BelongsTo{
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany{
        return $this->hasMany(self::class, 'parent_id');
    }

    ////////////////////////////

    public static function getGruposMusculares(){
        return self::all();
    }
}
