<?php

namespace Database\Seeders;

use App\Models\GrupoMuscular;
use Illuminate\Database\Seeder;

class GrupoMuscularSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $grupos = [
            'Pecho' => [
                'Pectoral superior',
                'Pectoral medio',
                'Pectoral inferior',
            ],
            'Espalda' => [
                'Dorsal ancho',
                'Trapecio',
                'Romboides',
                'Erectores espinales',
            ],
            'Hombros' => [
                'Deltoide anterior',
                'Deltoide lateral',
                'Deltoide posterior',
            ],
            'Brazos' => [
                'Biceps',
                'Triceps',
                'Antebrazos',
            ],
            'Piernas' => [
                'Cuadriceps',
                'Isquios',
                'Aductores',
                'Abductores',
                'Gemelos',
                'Gluteos',
            ],

            'Core' => [],
        ];

        foreach ($grupos as $grupoPadre => $subgrupos) {
            $padre = GrupoMuscular::firstOrCreate([
                'nombre' => $grupoPadre,
                'parent_id' => null,
            ]);

            foreach ($subgrupos as $subgrupo) {
                GrupoMuscular::firstOrCreate([
                    'nombre' => $subgrupo,
                    'parent_id' => $padre->id,
                ]);
            }
        }
    }
}
