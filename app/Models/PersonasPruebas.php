<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonasPruebas extends Model
{
    use HasFactory;
    protected $hidden = ['num_pruper'];
    protected $table = 'personas_pruebas';
    
    protected $fillable = ['con_emp', 'con_persona', 'hora_inicio', 'hora_finalizacion', 'minutos_utilizados',  'numsec_prueba', 'fecha_prueba', 'created_at', 'updated_at'];
public static function boot()
{
    parent::boot();

    static::saving(function ($model) {
    	$dt = date("Y-m-d H:i:s");
    	$hora = date("H:i:s");
         
        $model->fecha_prueba = $dt ;
        $model->hora_inicio = $hora ;
    });
}        
}
