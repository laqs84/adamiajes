<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresasPuestosCompetencias extends Model
{
    use HasFactory;
    protected $hidden = ['con_emp_pue_comp'];
    protected $table = 'empresas_puestos_competencias';
    protected $fillable = ['con_emp', 'con_pue', 'con_comp', 'con_nivdom', 'created_at', 'updated_at'];
}
