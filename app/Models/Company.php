<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'empresa';          // 👈 nombre REAL de tu tabla
    protected $primaryKey = 'id_empresa';  // 👈 PK real
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email_contacto',
    ];

    // Relación opcional si luego la usas
    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'empresa_id', 'id_empresa');
    }
}
