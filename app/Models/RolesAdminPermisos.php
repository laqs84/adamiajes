<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesAdminPermisos extends Model
{
    use HasFactory;
    protected $table = "admin_role_permissions";
    protected $fillable = ['role_id', 'permission_id', 'created_at', 'updated_at'];
}
