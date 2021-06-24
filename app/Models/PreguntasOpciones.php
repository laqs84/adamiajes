<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntasOpciones extends Model
{
    use HasFactory;
    protected $hidden = ['con_opci'];
    protected $table = 'competencias_preguntas_opciones';
    protected $fillable = ['con_comp','con_preg','descripcion','val_asiopci', 'created_at', 'updated_at'];
}
