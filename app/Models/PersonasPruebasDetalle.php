<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonasPruebasDetalle extends Model
{
    use HasFactory;
    protected $hidden = ['con_prue_det'];
    protected $table = 'persona_pruebas_detalle';
    
    protected $fillable = ['con_emp', 'con_persona', 'numsec_prueba', 'con_test', 'con_comp', 'con_preg', 'con_opci', 'created_at', 'updated_at'];
}
