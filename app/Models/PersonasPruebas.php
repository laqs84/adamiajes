<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonasPruebasDetalle extends Model
{
    use HasFactory;
    protected $hidden = ['num_pruper'];
    protected $table = 'persona_pruebas_detalle';
    
    protected $fillable = ['con_emp', 'con_persona', 'hora_inicio', 'hora_finalizacion', 'minutos_utilizados',  'numsec_prueba', 'fecha_prueba', 'created_at', 'updated_at'];
}
