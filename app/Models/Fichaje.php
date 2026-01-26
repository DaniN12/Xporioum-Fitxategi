<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fichaje extends Model
{
    protected $table = 'fichaje';
    protected $primaryKey = 'id_fichaje';
    public $timestamps = false;

    protected $fillable = [
        'alumno_id',
        'pin_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'total_horas',
    ];
}
