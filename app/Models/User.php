<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Fichaje;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuario';

    protected $primaryKey = 'id_usuario';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'contrasena',
        'nombre',
        'dni',
        'idioma_id',
        'activo',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    protected function casts(): array
    {
        return [];
    }

    public function fichajes()
    {
        return $this->hasMany(Fichaje::class, 'alumno_id', 'id_usuario');
    }
}
