<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresasPruebasBase extends Model
{
    use HasFactory;
    protected $hidden = ['con_test'];
    protected $table = 'empresas_pruebas_base';
    
    protected $fillable = ['descripcion', 'instrucciones', 'con_emp', 'con_tipo', 'usa_allcompdis', 'created_at', 'updated_at'];
}
