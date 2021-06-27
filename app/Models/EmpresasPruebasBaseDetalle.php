<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresasPruebasBaseDetalle extends Model
{
    use HasFactory;
    protected $hidden = ['con_detprubas'];
    protected $table = 'empresas_pruebas_base_detalle';
    protected $fillable = ['con_emp', 'con_test', 'con_comp', 'created_at', 'updated_at'];
}
