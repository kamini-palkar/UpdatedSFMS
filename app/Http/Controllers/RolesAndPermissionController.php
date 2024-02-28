<?php

namespace App\Http\Controllers;

use App\Models\OrganisationMasterModel;
use App\Models\RolesAndPermissionModel;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

class RolesAndPermissionController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->module_name="ACL";
    } 

    public function storeRolesAndPermission(Request $request)
   {
   
        $roleId = $request->roleid;

        $selectedpermissions = $request->selectedElmsIds; 
        DB::table('role_has_permissions')->where('role_id',$request->roleid)->delete();
        if(!empty($selectedpermissions)){
            $values = array();
            foreach ($selectedpermissions as $key => $value) {
                if($value[0] == 'j'){
                    continue;
                }
                $values[] = array( $value);
            }  
        }
    
        // Clear cached permissions
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    
        // Get the role
        $role = Role::findOrFail($roleId);
    
        // Detach existing permissions for the role
        $role->permissions()->detach();
    
        // Attach new permissions to the role
        foreach ($values as $permissionId) {
            $permission = Permission::findOrFail($permissionId);
            $role->givePermissionTo($permission);
        }
    
}

    public function showRP(Request $request)
    {
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();

        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' .$orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.'</li> <li class="breadcrumb-item active"><a href="/showroles_and_permission">ROLES HAS PERMISSION';
        $title="SFMS - $orgcode->code - $module_name";

        $Ads = Role::where('deleted_at', null)->get();

        return view('admin.RolesAndPermission.showroles_and_permission', ['Ads' => $Ads ,'title'=>$title,'breadcrumb'=>$breadcrumb]);
    }
}