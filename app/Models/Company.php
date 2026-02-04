<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'empresa';
    protected $primaryKey = 'id_empresa';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email_contacto',
    ];


    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'empresa_id', 'id_empresa');
    }
}
