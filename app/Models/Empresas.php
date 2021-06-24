<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;
    protected $hidden = ['con_emp'];
    
    protected $fillable = ['descripcion', 'email', 'contacto', 'telefono', 'puntaje_base', 'created_at', 'updated_at'];
}
