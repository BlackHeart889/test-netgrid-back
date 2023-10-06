<?php

namespace App\Models\Tareas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Proyectos\Proyecto;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';

    protected $fillable = [
        'id',
        'titulo',
        'descripcion',
        'id_estado',
        'id_proyecto',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }
}
