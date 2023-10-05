<?php

namespace Database\Seeders\Tareas;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Tareas\EstadoTarea;

class EstadoTareaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EstadoTarea::create(['nombre' => 'Pendiente']);
        EstadoTarea::create(['nombre' => 'En progreso']);
        EstadoTarea::create(['nombre' => 'Completada']);
    }
}
