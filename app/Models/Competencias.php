<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencias extends Model
{
    use HasFactory;
    protected $hidden = ['con_comp'];
    
    protected $fillable = ['descripcion', 'con_tipo', 'created_at', 'updated_at'];
}
