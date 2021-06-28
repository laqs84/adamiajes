<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaPruebas extends Model
{
    use HasFactory;
    protected $hidden = ['numsec_prueba'];
    protected $fillable = ['con_emp', 'con_pue', 'con_comp', 'descripcion', 'fecha_creacion', 'fecha_limite', 'tiempo_limite', 'link_prueba', 'created_at', 'updated_at'];
}
