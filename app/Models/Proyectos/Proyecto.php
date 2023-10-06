<?php

namespace App\Models\Proyectos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


use App\Models\User;
use App\Models\Tareas\Tarea;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        'id',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_finalizacion',
        'id_usuario',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function usuariosProyecto(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'usuariosproyectos', 'id_proyecto', 'id_usuario')->using(UsuarioProyecto::class);
    }

    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'id_proyecto', 'id');
    }
}
