<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Http\Resources\ProyectoResource;
use App\Http\Resources\ProyectoCollection;

use App\Models\Proyectos\{
    Proyecto,
    UsuarioProyecto,
};

class ProyectosController extends Controller
{
    public function crearProyecto(Request $request){
        $proyecto = $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'required|string|max:1000',
            'fecha_inicio' => 'required|date',
            'fecha_finalizacion' => 'required|date',
        ]);

        if(Carbon::parse($proyecto['fecha_inicio']) > Carbon::parse($proyecto['fecha_finalizacion'])){
            return response([
                'message' => 'La fecha de inicio del proyecto no puede ser mayor a la fecha de finalización',
            ], 422);
        }

        try {
            $proyecto['id_usuario'] = Auth::user()->id;
            Proyecto::create($proyecto);
            return response([
                'message' => 'Proyecto creado correctamente.',
            ], 200);
        } catch (\Throwable $th) {
            report($th);
            return response([
                'message' => 'Ocurrió un error al crear el proyecto.',
            ], 500);
        }
    }

    public function actualizarProyecto(Request $request){
        // $id = $request->query('id');
        $params = $request->validate([
            'id' => 'required|exists:proyectos,id',
        ]);

        $new_proyecto = $request->validate([
            'titulo' => 'sometimes|required|string|max:100',
            'descripcion' => 'sometimes|required|string|max:1000',
            'fecha_inicio' => 'sometimes|required|date',
            'fecha_finalizacion' => 'sometimes|required|date',
        ]);

        try {
            $proyecto = Proyecto::find($params['id']);
            $proyecto->fill($new_proyecto);
            $proyecto->save();

            return response([
                'message' => 'Proyecto actualizado correctamente.',
            ], 200);
        } catch (\Throwable $th) {
            report($th);
            return response([
                'message' => 'Ocurrió un error al actualizar el proyecto.',
            ], 500);
        }
    }

    public function detallesProyecto(Request $request){
        $params = $request->validate([
            'id' => 'required|exists:proyectos,id',
        ]);

        /**
         * Validar que el proyecto este asignado al usuario autenticado,
         * de lo contrario, responder con 422
         */

        return new ProyectoResource(Proyecto::find($params['id']));
    }

    public function proyectosCreados(Request $request){
        return new ProyectoCollection(Auth::user()->proyectosCreados()->paginate(10));
    }

    public function asignarProyecto(Request $request){
        $asignacion = $request->validate([
            'id_proyecto' => 'required|exists:proyectos,id',
            'id_usuario' => 'required|exists:users,id',
        ]);
        /**
         * Validar que el proyecto haya sido creado por el usuario autenticado,
         * de lo contrario, responder con 422
         */

        try {
            if($asignacion['id_usuario'] == Auth::user()->id){
                return response([
                    'message' => 'No puede asignarse el proyecto a usted mismo.'
                ], 422);
            }
            if(UsuarioProyecto::where('id_proyecto', $asignacion['id_proyecto'])->where('id_usuario', $asignacion['id_usuario'])->first() != null){
                return response([
                    'message' => 'El usuario ya se encuentra asignado a este proyecto.'
                ], 422);
            }

            UsuarioProyecto::create($asignacion);
            return response([
                'message' => 'Proyecto asignado correctamente.'
            ], 200);
        } catch (\Throwable $th) {
            report($th);
            return response([
                'message' => 'Ocurrió un error al asignar el proyecto.',
            ], 500);
        }
    }

    public function proyectosAsignados(Request $request){
        return new ProyectoCollection(Auth::user()->proyectosAsignados()->paginate(10));
    }

    public function eliminarProyecto(Request $request){
        $params = $request->validate([
            'id' => 'required|exists:proyectos,id',
        ]);
         /**
         * Validar que el proyecto haya sido creado por el usuario autenticado,
         * de lo contrario, responder con 422
         */
        try {
            Proyecto::destroy($params['id']);
            return response([
                'message' => 'Proyecto eliminado correctamente.'
            ], 200);
        } catch (\Throwable $th) {
            report($th);
            return response([
                'message' => 'Ocurrió un error al eliminar el proyecto.',
            ], 500);
        }
    }
}
