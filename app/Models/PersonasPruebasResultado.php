<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonasPruebasResultado extends Model
{
    use HasFactory;
    protected $table = 'persona_pruebas_resultado';
    
    protected $fillable = ['con_emp', 'con_persona', 'numsec_prueba', 'con_test', 'con_tipo', 'con_comp', 'con_puntaje', 'num_pruper', 'puntaje_obtenido', 'puntaje_esperado', 'puntaje_promedio', 'puntaje_final', 'balizq', 'balder', 'created_at', 'updated_at'];
}
