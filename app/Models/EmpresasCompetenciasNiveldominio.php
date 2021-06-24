<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresasCompetenciasNiveldominio extends Model
{
    use HasFactory;
    protected $hidden = ['con_comp_niv'];
     protected $table = 'empresas_competencias_niveldominio';
    protected $fillable = ['con_emp', 'email', 'con_nivdom', 'valor_esperado', 'created_at', 'updated_at'];
}
