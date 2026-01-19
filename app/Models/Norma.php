<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Norma extends Model {
    protected $table = 'normas';
    protected $primaryKey = 'id_norma';
    public $timestamps = false;
}
