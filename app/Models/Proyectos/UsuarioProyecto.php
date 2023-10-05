<?php

namespace App\Models\Proyectos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UsuarioProyecto extends Pivot
{
    use HasFactory;

    protected $table = 'usuariosproyectos';

    protected $fillable = [
        'id',
        'id_proyecto',
        'id_usuario',
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}
