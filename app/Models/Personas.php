<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    use HasFactory;
    protected $hidden = ['con_persona'];
    protected $fillable = ['con_emp', 'tipo_identificacion' , 'num_identificacion', 'nombres', 'apellido1', 'apellido2', 'email', 'tipo_persona', 'created_at', 'updated_at'];
}
