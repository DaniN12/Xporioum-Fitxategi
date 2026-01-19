<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $table = 'incidencia'; // Nombre de la tabla en tu SQL
    protected $primaryKey = 'id_incidencia'; // Tu PK según el SQL
    public $timestamps = false; // Tu tabla no tiene columnas de tiempo

    protected $fillable = ['alumno_id', 'profesor_id', 'fecha', 'motivo', 'estado'];
}
