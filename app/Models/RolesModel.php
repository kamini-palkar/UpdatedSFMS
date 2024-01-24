<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;


class RolesModel extends Model
{
    use HasFactory;
    use HasRoles;
    use SoftDeletes;
    use HasPermissions;

    protected  $table = "roles";
    protected $guarded = [];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
  
}
   