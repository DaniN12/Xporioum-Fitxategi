<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'contrasena',
        'nombre',
        'dni',
        'idioma_id',
        'activo'
    ];

    protected $hidden = ['contrasena'];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function profesor()
    {
        return $this->hasOne(Profesor::class, 'usuario_id');
    }

    public function alumno()
    {
        return $this->hasOne(Alumno::class, 'usuario_id');
    }
}
