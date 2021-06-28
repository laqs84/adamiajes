<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
    use HasFactory;
    protected $hidden = ['id'];
    protected $table = "admin_permissions";
    
    protected $fillable = ['name', 'slug', 'http_method', 'http_path', 'created_at', 'updated_at'];
}
