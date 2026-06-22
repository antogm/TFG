<?php

use App\Http\Controllers\EjercicioController;
use Illuminate\Support\Facades\Route;

Route::get('/ejercicios/catalogo', [EjercicioController::class, 'getEjerciciosAPI'])->name('api.ejercicios.catalogo');
