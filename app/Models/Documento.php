<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documento';
    protected $primaryKey = 'id_documento';
    public $timestamps = false; // porque tu tabla usa fecha_subida con CURRENT_TIMESTAMP

    protected $fillable = [
        'id_usuario',
        'incidencia',
        'nombre_archivo',
        'ruta_archivo',
        'tipo_archivo',
        'fecha_subida',
    ];
}
