<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonasPruebasDetalle extends Model
{
    use HasFactory;
    protected $hidden = ['num_pruper'];
    protected $table = 'personas_pruebas';
    
    protected $fillable = ['con_emp', 'con_persona', 'fecha_inicio', 'hora_inicio', 'hora_finalizacion', 'minutos_utilizados', 'fecha_limite', 'numsec_prueba', 'fecha_prueba', 'created_at', 'updated_at'];
}
