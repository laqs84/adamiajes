<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionResultados extends Model
{
    use HasFactory;
    protected $hidden = ['con_puntaje'];
    protected $table = 'calificacion_resultados';
    protected $fillable = ['aplicar_rr_no_ni','recomendacion','comportamiento_descriptivo','resultado_descriptivo','predominancia_resultado', 'con_tipo', 'con_comp', 'rango_inicial', 'rango_final', 'tipo_puntuacion', 'created_at', 'updated_at'];
}
