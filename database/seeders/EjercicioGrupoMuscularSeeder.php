<?php

namespace Database\Seeders;

use App\Models\Ejercicio;
use Illuminate\Database\Seeder;

class EjercicioGrupoMuscularSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ($this->relaciones() as $ejercicioId => $grupoIds) {
            $ejercicio = Ejercicio::query()->find($ejercicioId);

            if (!$ejercicio) {
                continue;
            }

            $ejercicio->gruposMusculares()->sync($grupoIds);
        }
    }

    private function relaciones(): array
    {
        return [
            1 => [19, 24, 25],
            2 => [19, 24, 25],
            3 => [19, 24, 25],
            4 => [19, 24],
            5 => [19, 24],
            6 => [19, 24],
            7 => [20, 24, 9],
            8 => [20, 24, 9],
            9 => [20, 24, 9],
            10 => [20],
            11 => [19],
            12 => [24, 20],
            13 => [21],
            14 => [22, 24],
            15 => [23],
            16 => [23],
            17 => [3, 16, 11],
            18 => [2, 16, 11],
            19 => [4, 16, 11],
            20 => [3],
            21 => [3],
            22 => [2],
            23 => [4],
            24 => [2],
            25 => [4, 16],
            26 => [3, 16, 25],
            27 => [6, 2],
            28 => [6, 15, 8],
            29 => [6, 15],
            30 => [6, 15],
            31 => [6, 8, 7],
            32 => [6, 8],
            33 => [6, 8],
            34 => [13, 7, 8],
            35 => [7],
            36 => [9, 24, 20],
            37 => [7, 9, 24],
            38 => [11, 16],
            39 => [11, 12, 16],
            40 => [12],
            41 => [12],
            42 => [11],
            43 => [13],
            44 => [15],
            45 => [15],
            46 => [15, 17],
            47 => [15],
            48 => [17, 15],
            49 => [16],
            50 => [16],
            51 => [16],
            52 => [16],
            53 => [16],
            54 => [17, 7, 25],
            55 => [25],
            56 => [25],
            57 => [25],
            58 => [25],
            59 => [25],
        ];
    }
}
