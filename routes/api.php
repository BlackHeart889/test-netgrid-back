<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{
    LoginController,
    ProyectosController,
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

        Route::post('/proyectos/crear', [ProyectosController::class, 'crearProyecto']);
        Route::delete('/proyectos/eliminar', [ProyectosController::class, 'eliminarProyecto']);

        Route::get('/proyectos/proyectos-creados', [ProyectosController::class, 'proyectosCreados']);
        Route::get('/proyectos/proyectos-asignados', [ProyectosController::class, 'proyectosAsignados']);


        Route::patch('/proyectos/actualizar', [ProyectosController::class, 'actualizarProyecto']);
        Route::post('/proyectos/asignar-proyecto', [ProyectosController::class, 'asignarProyecto']);
    });
});

