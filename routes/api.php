<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{
    LoginController,
    ProyectosController,
    TareasController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Recordar que:
 *
 * Para solicitudes post, se debe generar primero el Token CSRF a través de
 * /sanctum/csrf-token
 */
Route::middleware(['web'])->group(function () {
    Route::post('/register', [LoginController::class, 'register']);
    Route::post('/login', [LoginController::class, 'authenticate']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [LoginController::class, 'logout']);

        Route::middleware(['role:administrador'])->group(function () {
            Route::post('/proyectos/crear', [ProyectosController::class, 'crearProyecto']);
            Route::delete('/proyectos/eliminar', [ProyectosController::class, 'eliminarProyecto']);
            Route::get('/proyectos/creados', [ProyectosController::class, 'proyectosCreados']);
            Route::patch('/proyectos/actualizar', [ProyectosController::class, 'actualizarProyecto']);

            Route::post('/tareas/crear', [TareasController::class, 'crearTarea']);
            Route::post('/proyectos/asignar-proyecto', [ProyectosController::class, 'asignarProyecto']);
            Route::delete('/tareas/eliminar', [TareasController::class, 'eliminarTarea']);

        });

        Route::middleware(['role:regular'])->group(function () {
            Route::get('/proyectos/asignados', [ProyectosController::class, 'proyectosAsignados']);
        });

        Route::middleware(['role:administrador|regular'])->group(function () {
            Route::patch('/proyectos/actualizar', [ProyectosController::class, 'actualizarProyecto']);
            Route::patch('/tareas/actualizar', [TareasController::class, 'actualizarTarea']);

            Route::get('/proyectos/detalles', [ProyectosController::class, 'detallesProyecto']);
            Route::get('/tareas/detalles', [TareasController::class, 'detallesTarea']);
            Route::get('/tareas/creadas', [TareasController::class, 'listarTareas']);
        });

    });
});

