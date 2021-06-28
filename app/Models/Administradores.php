<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administradores extends Model
{
    use HasFactory;
    protected $hidden = ['id'];
    protected $table = "admin_users";
    protected $fillable = ['username', 'password', 'name', 'con_emp', 'avatar', 'remember_token', 'created_at', 'updated_at'];
}
