<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model {
    protected $table = 'documento';
    protected $primaryKey = 'id_documento';
    public $timestamps = false;
    protected $fillable = ['incidencia_id', 'nombre_archivo', 'ruta_archivo', 'tipo_archivo'];
}
