<?php

namespace App\Models\Tareas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoTarea extends Model
{
    use HasFactory;

    protected $table = 'estadostarea';

    protected $fillable = [
        'id',
        'nombre'
    ];
}
