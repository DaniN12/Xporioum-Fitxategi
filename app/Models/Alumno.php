<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumno';
    protected $primaryKey = 'id_alumno';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'profesor_id',
        'empresa_id',
        'fecha_alta',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id_usuario');
    }

    public function empresa()
    {
        return $this->belongsTo(Company::class, 'empresa_id', 'id_empresa');
    }
}
