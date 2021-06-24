<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetenciasNiveles extends Model
{
    use HasFactory;
    protected $hidden = ['con_nivdom'];
    protected $table = 'competencias_niveldominio';
    protected $fillable = ['descripcion', 'val_nivdom', 'created_at', 'updated_at'];
}
