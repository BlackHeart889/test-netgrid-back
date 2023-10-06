<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Resources\TareaCollection;

use App\Models\Proyectos\Proyecto;
use App\Models\Tareas\Tarea;

use App\Http\Resources\TareaResource;

class TareasController extends Controller
{
    public function crearTarea(Request $request){
        $tarea = $request->validate([
            'id_proyecto' => 'required|exists:proyectos,id',
            'titulo' => 'required|string|max:100',
            'descripcion' => 'required|string|max:1000',
            'id_estado' => 'required|exists:estadostarea,id',
        ]);

        try {
            Tarea::create($tarea);
            return response([
                'message' => 'Tarea creada correctamente.',
            ], 200);
        } catch (\Throwable $th) {
            report($th);
            return response([
                'message' => 'Ocurrió un error al crear la tarea.',
            ], 500);
        }
    }

    public function detallesTarea(Request $request){
        $params = $request->validate([
            'id' => 'required|exists:tareas,id',
        ]);

        return new TareaResource(Tarea::find($params['id']));
    }

    public function actualizarTarea(Request $request){
        $params = $request->validate([
            'id' => 'required|exists:tareas,id',
        ]);

        /**
         * Validar que la tarea haya sido creado por el usuario autenticado,
         * de lo contrario, responder con 422
         *
         * validar el rol para reutilizar este metodo para ambos roles
         */
        $user = Auth::user()->roles->first()->name;
        $new_tarea;
        switch ($user) {
            case 'administrador':
                $new_tarea = $request->validate([
                    'titulo' => 'sometimes|required|string|max:100',
                    'descripcion' => 'sometimes|required|string|max:1000',
                    'id_estado' => 'sometimes|required|exists:estadostarea,id'
                ]);
                break;
            case 'regular':
                $new_tarea = $request->validate([
                    'id_estado' => 'required|exists:estadostarea,id'
                ]);
                break;
            default:
                return response([
                    'message' => 'No posee los roles necesarios para esta acción',
                ], 500);
                break;
        }
        // $new_tarea = $request->validate([
        //     'titulo' => 'sometimes|required|string|max:100',
        //     'descripcion' => 'sometimes|required|string|max:1000',
        //     'id_estado' => 'sometimes|required|exists:estadostarea,id'
        // ]);

        try {
            $tarea = Tarea::find($params['id']);
            $tarea->fill($new_tarea);
            $tarea->save();

            return response([
                'message' => 'Tarea actualizada correctamente.',
            ], 200);
        } catch (\Throwable $th) {
            report($th);
            return response([
                'message' => 'Ocurrió un error al actualizar la tarea.',
            ], 500);
        }
    }

    public function listarTareas(Request $request){
        $params = $request->validate([
            'id' => 'required|exists:proyectos,id',
        ]);

        /**
         * Validar que el proyecto haya sido asignado al usuario autenticado,
         * de lo contrario, responder con 422
         */

        return new TareaCollection(Proyecto::find($params['id'])->tareas()->paginate(10));
    }

    public function eliminarTarea(Request $request){
        $params = $request->validate([
            'id' => 'required|exists:tareas,id',
        ]);

        /**
         * Validar que el proyecto haya sido creado por el usuario autenticado,
         * de lo contrario, responder con 422
         */

        try {
            Tarea::destroy($params['id']);
            return response([
                'message' => 'Tarea eliminada correctamente.'
            ], 200);
        } catch (\Throwable $th) {
            report($th);
            return response([
                'message' => 'Ocurrió un error al eliminar la tarea.',
            ], 500);
        }
    }
}
