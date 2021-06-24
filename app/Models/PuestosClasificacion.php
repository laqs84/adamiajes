<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuestosClasificacion extends Model
{
    use HasFactory;
    protected $table = 'puestos_clasificacion';
    protected $hidden = ['con_clapue'];
    
    protected $fillable = ['descripcion', 'created_at', 'updated_at'];
}
