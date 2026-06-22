<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ClienteEntrenadorController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\EntrenadorController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistroCorporalController;
use App\Http\Controllers\RegistroEntrenamientoController;
use App\Http\Controllers\RutinaController;
use App\Models\Ejercicio;
use App\Models\Rutina;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Página pública
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->rol === 'entrenador') {
            return redirect()->route('entrenador.dashboard');
        }

        return redirect()->route('cliente.dashboard');
    }

    return view('homepage');
})->name('homepage');

// Página principal tras login
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->rol === 'entrenador') {
        return redirect()->route('entrenador.dashboard');
    }

    return redirect()->route('cliente.dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/dashboard/cliente', [ClienteController::class, 'dashboard'])
    ->middleware(['auth', 'role:usuario'])
    ->name('cliente.dashboard');

Route::get('/dashboard/entrenador', [EntrenadorController::class, 'dashboard'])
    ->middleware(['auth', 'role:entrenador'])
    ->name('entrenador.dashboard');

// Páginas privadas
Route::middleware('auth')->group(function () {
    Route::post('/locale', [LocaleController::class, 'update'])->name('locale.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/entrenadores', [ClienteController::class, 'entrenadores'])->name('entrenadores.index');

    Route::get('/entrenadores/{entrenador}', [ClienteController::class, 'detalleEntrenador'])
        ->whereNumber('entrenador')
        ->name('entrenadores.show');

    Route::post('/entrenadores/{entrenador}/valorar', [ClienteEntrenadorController::class, 'valorar'])
        ->middleware('role:usuario')
        ->whereNumber('entrenador')
        ->name('entrenadores.valorar');

    Route::delete('/entrenadores/{entrenador}/valoracion', [ClienteEntrenadorController::class, 'eliminarValoracion'])
        ->middleware('role:usuario')
        ->whereNumber('entrenador')
        ->name('entrenadores.valoracion.eliminar');

    Route::get('/usuario/{id}', [ClienteController::class, 'panelProgreso'])
        ->middleware('trainer_or_client:id')
        ->whereNumber('id')
        ->name('usuario.progreso');

    Route::get('/usuario/historial/{id}', [ClienteController::class, 'historialCompleto'])
        ->middleware('trainer_or_client:id')
        ->whereNumber('id')
        ->name('usuario.historial');

    Route::get('/usuario/{id}/historial/entrenos/{registroEntrenamiento}', [ClienteController::class, 'detalleEntreno'])
        ->middleware('trainer_or_client:id')
        ->whereNumber('id')
        ->whereNumber('registroEntrenamiento')
        ->name('usuario.historial-entreno.detalle');

    Route::get('/usuario/{id}/historial/entrenos/{registroEntrenamiento}/edit', [RegistroEntrenamientoController::class, 'edit'])
        ->whereNumber('id')
        ->whereNumber('registroEntrenamiento')
        ->name('usuario.historial-entreno.edit');

    Route::patch('/usuario/{id}/historial/entrenos/{registroEntrenamiento}', [RegistroEntrenamientoController::class, 'update'])
        ->whereNumber('id')
        ->whereNumber('registroEntrenamiento')
        ->name('usuario.historial-entreno.update');

    Route::delete('/usuario/{id}/historial/entrenos/{registroEntrenamiento}', [RegistroEntrenamientoController::class, 'delete'])
        ->whereNumber('id')
        ->whereNumber('registroEntrenamiento')
        ->name('usuario.historial-entreno.delete');

    // Rutinas
    Route::get('/rutinas', [RutinaController::class, 'index'])
        ->middleware('role:entrenador')
        ->name('rutinas.lista-rutinas');

    Route::get('/rutinas/actual', [RutinaController::class, 'actual'])
        ->middleware('role:usuario')
        ->name('rutinas.actual');

    Route::get('/rutinas/create', [RutinaController::class, 'create'])
        ->middleware('can:create,'.Rutina::class)
        ->name('rutinas.create');

    Route::get('/rutinas/{rutina_id}', [RutinaController::class, 'get'])
        ->whereNumber('rutina_id')
        ->name('rutinas.get');

    Route::get('/rutinas/{rutina}/registrar-entrenamiento', [RegistroEntrenamientoController::class, 'create'])
        ->middleware('role:usuario')
        ->whereNumber('rutina')
        ->name('rutinas.registro-entrenamiento.create');

    Route::post('/rutinas/{rutina}/registrar-entrenamiento', [RegistroEntrenamientoController::class, 'store'])
        ->middleware('role:usuario')
        ->whereNumber('rutina')
        ->name('rutinas.registro-entrenamiento.store');

    Route::get('/rutinas/edit/{rutina}', [RutinaController::class, 'edit'])
        ->middleware('can:update,rutina')
        ->whereNumber('rutina')
        ->name('rutinas.edit');

    Route::patch('/rutinas/update/{rutina}', [RutinaController::class, 'update'])
        ->middleware('can:update,rutina')
        ->whereNumber('rutina')
        ->name('rutinas.update');

    Route::delete('/rutinas/delete/{rutina}', [RutinaController::class, 'delete'])
        ->middleware('can:delete,rutina')
        ->whereNumber('rutina')
        ->name('rutinas.delete');

    Route::post('/rutinas/store', [RutinaController::class, 'store'])
        ->middleware('can:create,'.Rutina::class)
        ->name('rutinas.store');

    Route::patch('/clientes/{cliente}/asignar-rutina', [RutinaController::class, 'asignarCliente'])
        ->middleware('role:entrenador')
        ->whereNumber('cliente')
        ->name('clientes.rutina.asignar');

    Route::patch('/clientes/{cliente}/desasignar-rutina', [RutinaController::class, 'desasignarCliente'])
        ->middleware('role:entrenador')
        ->whereNumber('cliente')
        ->name('clientes.rutina.desasignar');

    Route::patch('/rutinas/{rutina}/asignar', [RutinaController::class, 'asignarClientes'])
        ->middleware('role:entrenador')
        ->whereNumber('rutina')
        ->name('rutinas.clientes.asignar');

    // Mensajería
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');

    Route::get('/conversations/start/{user}', [ConversationController::class, 'start'])
        ->whereNumber('user')
        ->name('conversations.start');

    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])
        ->whereNumber('conversation')
        ->name('conversations.show');

    Route::post('/conversations/{conversation}/store-message', [MessageController::class, 'store'])
        ->whereNumber('conversation')
        ->name('messages.store');

    // Registro corporal
    Route::get('/registrocorporal/create', [RegistroCorporalController::class, 'create'])->name('registrocorporal.create');

    Route::get('/registrocorporal/edit/{registroCorporal}', [RegistroCorporalController::class, 'edit'])
        ->middleware('can:update,registroCorporal')
        ->whereNumber('registroCorporal')
        ->name('registrocorporal.edit');

    Route::get('/registrocorporal/ver/{registroCorporal}', [RegistroCorporalController::class, 'ver'])
        ->middleware('can:view,registroCorporal')
        ->whereNumber('registroCorporal')
        ->name('registrocorporal.ver');

    Route::get('/registrocorporal/imagenes/{id_usuario}/{imagen}', [RegistroCorporalController::class, 'imagen'])
        ->whereNumber('id_usuario')
        ->whereNumber('imagen')
        ->name('registrocorporal.imagenes.show');

    Route::post('/registrocorporal/store', [RegistroCorporalController::class, 'store'])->name('registrocorporal.store');

    Route::patch('/registrocorporal/update/{registroCorporal}', [RegistroCorporalController::class, 'update'])
        ->middleware('can:update,registroCorporal')
        ->whereNumber('registroCorporal')
        ->name('registrocorporal.update');

    Route::delete('/registrocorporal/delete/{registroCorporal}', [RegistroCorporalController::class, 'delete'])
        ->middleware('can:delete,registroCorporal')
        ->whereNumber('registroCorporal')
        ->name('registrocorporal.delete');

    // Cliente-entrenador
    Route::post('/colaboracion/solicitar/{entrenador}', [ClienteEntrenadorController::class, 'solicitar'])
        ->whereNumber('entrenador')
        ->name('cliente-entrenador.solicitar');
    Route::patch('/colaboracion/cancelar/{entrenador}/{cliente?}', [ClienteEntrenadorController::class, 'cancelar'])
        ->whereNumber('entrenador')
        ->whereNumber('cliente')
        ->name('cliente-entrenador.cancelar');
    Route::patch('/colaboracion/aceptar/{userId}', [ClienteEntrenadorController::class, 'aceptar'])
        ->middleware('role:entrenador')
        ->whereNumber('userId')
        ->name('cliente-entrenador.aceptar');

    Route::patch('/colaboracion/rechazar/{userId}', [ClienteEntrenadorController::class, 'rechazar'])
        ->middleware('role:entrenador')
        ->whereNumber('userId')
        ->name('cliente-entrenador.rechazar');

    Route::get('/clientes', [EntrenadorController::class, 'clientes'])
        ->middleware('role:entrenador')
        ->name('entrenador.clientes');

    Route::patch('/entrenador/profile', [EntrenadorController::class, 'updateProfile'])
        ->middleware('role:entrenador')
        ->name('entrenador.actualizarPerfil');

    Route::patch('/entrenador/alta', [EntrenadorController::class, 'altaEntrenador'])
        ->name('entrenador.alta');
    Route::patch('/entrenador/baja', [EntrenadorController::class, 'bajaEntrenador'])
        ->middleware('role:entrenador')
        ->name('entrenador.baja');

    // Ejercicios
    Route::get('/ejercicios', [EjercicioController::class, 'index'])
        ->name('ejercicios.index');

    Route::get('/ejercicios/create', [EjercicioController::class, 'create'])
        ->middleware('can:create,'.Ejercicio::class)
        ->name('ejercicios.create');

    Route::post('/ejercicios/store', [EjercicioController::class, 'store'])
        ->middleware('can:create,'.Ejercicio::class)
        ->name('ejercicios.store');

    Route::get('/ejercicios/edit/{ejercicio}', [EjercicioController::class, 'edit'])
        ->middleware('can:update,ejercicio')
        ->whereNumber('ejercicio')
        ->name('ejercicios.edit');

    Route::patch('/ejercicios/update/{ejercicio}', [EjercicioController::class, 'update'])
        ->middleware('can:update,ejercicio')
        ->whereNumber('ejercicio')
        ->name('ejercicios.update');

    Route::get('/ejercicios/get/{idEjercicio}', [EjercicioController::class, 'verEjercicio'])
        ->whereNumber('idEjercicio')
        ->name('ejercicios.ver');

    //
    Route::get('/entrenador/gestion-solicitudes', [ClienteEntrenadorController::class, 'gestionarSolicitudes'])
        ->middleware('role:entrenador')
        ->name('entrenador.gestionarSolicitudes');
});

require __DIR__.'/auth.php';
