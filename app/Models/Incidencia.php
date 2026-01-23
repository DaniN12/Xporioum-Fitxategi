<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $table = 'incidencias'; // Nombre de la tabla en tu SQL
    public $timestamps = false; // Tu tabla no tiene columnas de tiempo

    protected $fillable = ['fecha', 'motivo'];
}
