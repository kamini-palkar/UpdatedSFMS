<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles;

class PermissionModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasRoles;
    protected $table = "permissions";

    protected $fillable = ['name', 'guard_name'];

    public function fetchPermission()
    {
        return PermissionModel::all();
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
