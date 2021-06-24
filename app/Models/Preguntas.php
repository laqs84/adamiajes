<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
    use HasFactory;
    protected $hidden = ['con_preg'];
    protected $table = 'competencias_preguntas';
    protected $fillable = ['con_comp','descripcion', 'created_at', 'updated_at'];
}
