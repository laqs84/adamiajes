<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaPruebas extends Model
{
    use HasFactory;
    protected $hidden = ['numsec_prueba'];
    protected $table = 'empresa_pruebas';
    
    protected $fillable = ['descripcion', 'fecha_creacion', 'con_emp', 'con_pue', 'fecha_inicio', 'fecha_limite', 'tiempo_limite', 'link_prueba', 'created_at', 'updated_at'];

public static function boot()
{
    parent::boot();

    static::saving(function ($model) {
    	$dt = date("Y-m-d H:i:s");
         
        $model->fecha_creacion = $dt ;
    });
}    
}
