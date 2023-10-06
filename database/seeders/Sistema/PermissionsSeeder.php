<?php

namespace Database\Seeders\Sistema;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * tarabajar solo roles
         */
        // $permissions = [
        //     //Administrador
        //     ['name' => 'crear proyectos'],
        //     ['name' => 'actualizar proyectos'],
        //     ['name' => 'asignar proyectos'],
        //     ['name' => 'listar proyectos creados'],
        //     ['name' => 'eliminar proyectos'],

        //     ['name' => 'crear tareas'],
        //     ['name' => 'actualizar tareas'],
        //     ['name' => 'asignar tareas'],
        //     ['name' => 'eliminar tareas'],
        //     //Usuario regular
        //     ['name' => 'listar proyectos asignados'],
        //     ['name' => 'cambiar estado tarea'],
        //     //para todos
        //     ['name' => 'listar tareas'],
        //     ['name' => 'ver detalles proyecto'],
        //     ['name' => 'ver detalles tarea'],
        // ];

        // foreach ($permissions as $permission) {
        //     Permission::create($permission);
        // }

        $administrador = Role::create(['name' => 'administrador']);
        $regular = Role::create(['name' => 'regular']);

        // $administrador->syncPermissions([
        //     'crear proyectos',
        //     'actualizar proyectos',
        //     'asignar proyectos',
        //     'listar proyectos creados',
        //     'eliminar proyectos',
        //     'crear tareas',
        //     'actualizar tareas',
        //     'asignar tareas',
        //     'eliminar tareas',
        //     'listar tareas',
        //     'ver detalles proyecto',
        //     'ver detalles tarea',
        // ]);

        // $regular->syncPermissions([
        //     'listar proyectos asignados',
        //     'cambiar estado tarea',
        //     'listar tareas',
        //     'ver detalles proyecto',
        //     'ver detalles tarea',
        // ]);
    }
}
