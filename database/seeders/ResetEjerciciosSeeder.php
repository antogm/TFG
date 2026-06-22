<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResetEjerciciosSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('ejercicio_grupo_muscular')->truncate();
        DB::table('ejercicios')->truncate();
        DB::table('grupos_musculares')->truncate();

        DB::statement('ALTER TABLE ejercicio_grupo_muscular AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE ejercicios AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE grupos_musculares AUTO_INCREMENT = 1');

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
