<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaPruebasDetalle extends Model
{
    use HasFactory;
    protected $hidden = ['con_detpru'];
    protected $table = 'empresa_pruebas_detalle';
    protected $fillable = ['con_emp', 'con_test', 'numsec_prueba', 'created_at', 'updated_at'];
}
