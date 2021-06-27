<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recomendaciones extends Model
{
    use HasFactory;
    protected $hidden = ['consecutivo_recomendacion'];
    protected $table = 'cal_res_recomendaciones';
    protected $fillable = ['con_puntaje','detalle_recomendacion', 'created_at', 'updated_at'];
}
