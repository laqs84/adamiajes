<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetenciasTipos extends Model
{
    protected $table = 'competencias_tipos';
    protected $hidden = ['con_tipo'];
    protected $fillable = ['descripcion', 'tipo_calificacion', 'created_at', 'updated_at'];

    use HasFactory;
}
