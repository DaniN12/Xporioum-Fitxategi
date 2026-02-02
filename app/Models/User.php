<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Fichaje;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ✅ Tu tabla real
    protected $table = 'usuario';

    // ✅ Tu clave primaria real
    protected $primaryKey = 'id_usuario';

    // ✅ No tienes created_at / updated_at
    public $timestamps = false;

    // ✅ Campos reales de tu tabla
    protected $fillable = [
        'email',
        'contrasena',
        'nombre',
        'dni',
        'idioma_id',
        'activo',
    ];

    // ✅ Ocultar el password real
    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    // ✅ Laravel debe usar "contrasena" como password
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // (Opcional) Casts si quieres, pero NO uses 'password' => 'hashed'
    protected function casts(): array
    {
        return [
            // no tienes email_verified_at en la tabla según tu captura
        ];
    }

    public function fichajes()
    {
        // ⚠️ Ajusta estas claves si tu tabla fichaje apunta a id_usuario
        return $this->hasMany(Fichaje::class, 'alumno_id', 'id_usuario');
    }
}
