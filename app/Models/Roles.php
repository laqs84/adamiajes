<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $hidden = ['id'];
    protected  $table = "admin_roles";
    protected $fillable = ['name', 'slug', 'created_at', 'updated_at'];
}
